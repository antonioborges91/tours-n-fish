<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    /**
     * Lista todas as reservas.
     */
    public function index()
    {
        $reservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
                'schedule',
            ])
            ->orderByRaw(
                "CASE
                    WHEN status = 'payment_submitted' THEN 0
                    WHEN status = 'pending_payment' THEN 1
                    WHEN status = 'confirmed' THEN 2
                    WHEN status = 'rejected' THEN 3
                    WHEN status = 'cancelled' THEN 4
                    WHEN status = 'expired' THEN 5
                    ELSE 6
                END"
            )
            ->orderBy('booking_date')
            ->orderBy('start_at')
            ->orderByDesc('id')
            ->get();

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
        ]);

        return view(
            'admin.reservations.show',
            compact('reservation')
        );
    }


    /**
     * Atualiza o estado da reserva.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in([
                    'pending_payment',
                    'payment_submitted',
                    'confirmed',
                    'rejected',
                    'cancelled',
                    'expired',
                ]),
            ],
        ]);


        $newStatus = $validated['status'];


        /*
        |--------------------------------------------------------------------------
        | Datas associadas ao estado
        |--------------------------------------------------------------------------
        */

        $updates = [
            'status' => $newStatus,
        ];


        if ($newStatus === 'confirmed') {
            $updates['confirmed_at'] = now();
            $updates['cancelled_at'] = null;
        }


        if ($newStatus === 'cancelled') {
            $updates['cancelled_at'] = now();
            $updates['confirmed_at'] = null;
        }


        if ($newStatus === 'rejected') {
            $updates['confirmed_at'] = null;
            $updates['cancelled_at'] = null;
        }


        if ($newStatus === 'pending_payment') {
            $updates['confirmed_at'] = null;
            $updates['cancelled_at'] = null;
        }


        if ($newStatus === 'payment_submitted') {
            $updates['confirmed_at'] = null;
            $updates['cancelled_at'] = null;

            /*
             * Não criamos uma nova data se o cliente
             * já submeteu o comprovativo.
             *
             * A data pertence ao momento em que o cliente
             * efetivamente enviou o comprovativo.
             */
            if (! $reservation->payment_submitted_at) {
                $updates['payment_submitted_at'] = now();
            }
        }


        if ($newStatus === 'expired') {
            $updates['confirmed_at'] = null;
            $updates['cancelled_at'] = null;
        }


        $reservation->update($updates);


        return redirect()
            ->route('admin.reservations.show', $reservation)
            ->with(
                'success',
                'Estado da reserva atualizado com sucesso.'
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
}