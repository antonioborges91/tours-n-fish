<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedPeriod;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    /**
     * Lista todas as reservas.
     */
    public function index(Request $request)
    {
        $allowedStatuses = [
            'pending_payment',
            'payment_submitted',
            'confirmed',
            'rejected',
            'cancelled',
            'expired',
        ];

        $status = $request->input('status');

        if (! in_array($status, $allowedStatuses, true)) {
            $status = null;
        }

        $search = trim(
            (string) $request->input('search')
        );

        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $reservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
                'schedule',
            ])
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($query) use ($search) {

                    $query
                        ->where(
                            'reservation_number',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'customer_name',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'customer_email',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'customer_phone',
                            'like',
                            '%' . $search . '%'
                        );

                });

            })
            ->when($status, function ($query) use ($status) {

                $query->where(
                    'status',
                    $status
                );

            })
            ->when($dateFrom, function ($query) use ($dateFrom) {

                $query->whereDate(
                    'booking_date',
                    '>=',
                    $dateFrom
                );

            })
            ->when($dateTo, function ($query) use ($dateTo) {

                $query->whereDate(
                    'booking_date',
                    '<=',
                    $dateTo
                );

            })
            ->orderByDesc('booking_date')
            ->orderBy('start_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view(
            'admin.reservations.index',
            compact('reservations')
        );
    }


    /**
     * Mostra os detalhes de uma reserva.
     */
    public function show(Reservation $reservation)
    {
        $reservation->load([
            'tour.translations',
            'option.translations',
            'schedule',
            'blockedPeriods',
        ]);

        return view(
            'admin.reservations.show',
            compact('reservation')
        );
    }


    /**
     * Visualiza o comprovativo de pagamento.
     */
    public function paymentProof(Reservation $reservation)
    {
        abort_unless(
            $reservation->payment_proof,
            404
        );

        $disk = Storage::disk('payment_proofs');

        abort_unless(
            $disk->exists($reservation->payment_proof),
            404
        );

        return response()->file(
            $disk->path($reservation->payment_proof)
        );
    }


    /**
     * Confirma o pagamento de uma reserva.
     */
    public function confirmPayment(Reservation $reservation)
    {
        abort_unless(
            $reservation->status === 'payment_submitted'
            && $reservation->payment_proof,
            403
        );

        $reservation->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return redirect()
            ->route(
                'admin.reservations.show',
                $reservation
            )
            ->with(
                'success',
                'O pagamento foi confirmado e a reserva está confirmada.'
            );
    }


    /**
     * Rejeita o comprovativo de pagamento.
     */
    public function rejectPayment(Reservation $reservation)
    {
        abort_unless(
            $reservation->status === 'payment_submitted'
            && $reservation->payment_proof,
            403
        );

        $reservation->update([
            'status' => 'rejected',
        ]);

        return redirect()
            ->route(
                'admin.reservations.show',
                $reservation
            )
            ->with(
                'success',
                'O comprovativo foi rejeitado e a reserva foi marcada como rejeitada.'
            );
    }


    /**
     * Bloqueia o restante do dia de uma reserva confirmada.
     *
     * Exemplo:
     *
     * Reserva 08:00 - 12:00
     * → 00:00 - 08:00
     * → 12:00 - 23:59:59
     *
     * Reserva 14:00 - 17:00
     * → 00:00 - 14:00
     * → 17:00 - 23:59:59
     */
    public function blockRemainingDay(Reservation $reservation)
    {
        DB::transaction(function () use ($reservation) {

            /*
             * Bloquear a própria reserva evita ações
             * administrativas concorrentes sobre a mesma reserva.
             */
            $reservation = Reservation::query()
                ->lockForUpdate()
                ->findOrFail($reservation->id);

            /*
             * Só uma reserva confirmada pode bloquear o dia.
             */
            abort_unless(
                $reservation->status === 'confirmed',
                403
            );

            /*
             * Não permitir duplicação de bloqueios.
             */
            if ($reservation->blockedPeriods()->exists()) {
                return;
            }

            $date = $reservation->booking_date->format('Y-m-d');

            $dayStart = Carbon::parse(
                $date . ' 00:00:00'
            );

            $bookingStart = Carbon::parse(
                $date . ' ' . $reservation->start_at
            );

            $bookingEnd = Carbon::parse(
                $date . ' ' . $reservation->end_at
            );

            $dayEnd = Carbon::parse(
                $date . ' 23:59:59'
            );

            /*
             * Bloqueio antes da reserva.
             */
            if ($bookingStart->gt($dayStart)) {
                BlockedPeriod::create([
                    'reservation_id' => $reservation->id,
                    'start_at' => $dayStart,
                    'end_at' => $bookingStart,
                    'reason' => 'Bloqueio associado à reserva #' .
                        $reservation->reservation_number,
                ]);
            }

            /*
             * Bloqueio depois da reserva.
             */
            if ($bookingEnd->lt($dayEnd)) {
                BlockedPeriod::create([
                    'reservation_id' => $reservation->id,
                    'start_at' => $bookingEnd,
                    'end_at' => $dayEnd,
                    'reason' => 'Bloqueio associado à reserva #' .
                        $reservation->reservation_number,
                ]);
            }
        });

        if ($reservation->blockedPeriods()->exists()) {
            return redirect()
                ->route(
                    'admin.reservations.show',
                    $reservation
                )
                ->with(
                    'success',
                    'O restante do dia foi bloqueado com sucesso.'
                );
        }

        return redirect()
            ->route(
                'admin.reservations.show',
                $reservation
            )
            ->with(
                'error',
                'O restante do dia desta reserva já estava bloqueado.'
            );
    }


    /**
     * Cancela uma reserva através da administração.
     *
     * A reserva permanece na base de dados com o estado cancelled.
     * Todos os bloqueios associados são removidos.
     */
    public function cancel(Reservation $reservation)
    {
        /*
         * Estes são os únicos estados que podem ser cancelados
         * através da administração.
         */
        if (! in_array($reservation->status, [
            'pending_payment',
            'payment_submitted',
            'confirmed',
        ], true)) {
            return redirect()
                ->route(
                    'admin.reservations.show',
                    $reservation
                )
                ->with(
                    'error',
                    'Esta reserva não pode ser cancelada neste estado.'
                );
        }

        DB::transaction(function () use ($reservation) {

            /*
             * Remover todos os bloqueios associados.
             */
            $reservation->blockedPeriods()->delete();

            /*
             * Manter a reserva na base de dados,
             * mas alterar o estado para cancelled.
             */
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);
        });

        return redirect()
            ->route(
                'admin.reservations.show',
                $reservation
            )
            ->with(
                'success',
                'A reserva foi cancelada com sucesso.'
            );
    }


    /**
     * Elimina definitivamente uma reserva.
     *
     * Remove também:
     * - bloqueios associados;
     * - comprovativo de pagamento.
     */
    public function destroy(Reservation $reservation)
    {
        $paymentProof = $reservation->payment_proof;

        DB::transaction(function () use ($reservation) {

            /*
             * Remover primeiro os bloqueios associados.
             */
            $reservation->blockedPeriods()->delete();

            /*
             * Depois eliminar definitivamente a reserva.
             */
            $reservation->delete();
        });

        /*
         * O comprovativo está num disco privado separado.
         */
        if ($paymentProof) {
            Storage::disk('payment_proofs')->delete(
                $paymentProof
            );
        }

        return redirect()
            ->route('admin.reservations.index')
            ->with(
                'success',
                'A reserva foi eliminada com sucesso.'
            );
    }
}