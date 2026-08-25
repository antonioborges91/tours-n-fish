<?php

namespace App\Http\Controllers;

use App\Models\BlockedPeriod;
use App\Models\Reservation;
use App\Models\Tour;
use App\Models\TourOption;
use App\Models\TourOptionSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\ReservationCreated;

class ReservationController extends Controller
{
    
    /**
     * Cria uma nova reserva.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validar dados enviados pelo cliente
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'tour_option_id' => [
                'required',
                'integer',
                'exists:tour_options,id',
            ],

            'tour_option_schedule_id' => [
                'required',
                'integer',
                'exists:tour_option_schedules,id',
            ],

            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],

            'participants' => [
                'required',
                'integer',
                'min:1',
            ],

            'customer_name' => [
                'required',
                'string',
                'max:255',
            ],

            'customer_email' => [
                'required',
                'email',
                'max:255',
            ],

            'customer_phone' => [
                'required',
                'string',
                'max:50',
            ],

            'customer_message' => [
                'nullable',
                'string',
                'max:5000',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Obter opção
        |--------------------------------------------------------------------------
        */

        $option = TourOption::findOrFail(
            $validated['tour_option_id']
        );


        /*
        |--------------------------------------------------------------------------
        | Obter horário
        |--------------------------------------------------------------------------
        */

        $schedule = TourOptionSchedule::findOrFail(
            $validated['tour_option_schedule_id']
        );


        /*
        |--------------------------------------------------------------------------
        | Validar relação entre opção e horário
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $schedule->tour_option_id === $option->id,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Obter passeio através da opção
        |--------------------------------------------------------------------------
        */

        $tour = Tour::findOrFail(
            $option->tour_id
        );


        /*
        |--------------------------------------------------------------------------
        | O passeio tem de estar disponível
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $tour->available,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | Validar capacidade
        |--------------------------------------------------------------------------
        */

        if ($validated['participants'] > $tour->max_capacity) {

            return back()
                ->withErrors([
                    'participants' => 'O número de pessoas excede a capacidade máxima do barco.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Obter horários exclusivamente do schedule
        |--------------------------------------------------------------------------
        */

        $startAt = $schedule->start_time;
        $endAt = $schedule->end_time;


        /*
        |--------------------------------------------------------------------------
        | Não permitir reservas com menos de 12 horas de antecedência
        |--------------------------------------------------------------------------
        */

        $bookingStart = Carbon::parse(
            $validated['booking_date'] . ' ' . $startAt
        );

        if ($bookingStart->lt(now()->addHours(12))) {

            return back()
                ->withErrors([
                    'booking_date' => 'Este horário já não pode ser reservado. As reservas devem ser feitas com pelo menos 12 horas de antecedência.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Verificar disponibilidade
        |--------------------------------------------------------------------------
        */

        if (! $this->isSlotAvailable(
            $validated['booking_date'],
            $startAt,
            $endAt
        )) {

            return back()
                ->withErrors([
                    'booking_date' => 'O horário escolhido não está disponível nessa data.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Calcular valores
        |--------------------------------------------------------------------------
        */

        $totalAmount = (float) $option->price;

        $depositPercentage = 10.00;

        $depositAmount = round(
            $totalAmount * ($depositPercentage / 100),
            2
        );


        /*
        |--------------------------------------------------------------------------
        | Prazo para pagamento do sinal
        |--------------------------------------------------------------------------
        */

        $paymentDeadline = Carbon::parse(
            $validated['booking_date'] . ' ' . $startAt
        )->subDays(3);

        if ($paymentDeadline->lte(now())) {
            $paymentDeadline = now()->addHours(2);
        }


        /*
        |--------------------------------------------------------------------------
        | Criar reserva
        |--------------------------------------------------------------------------
        |
        | O ano do número corresponde ao ano do passeio.
        |
        | Exemplo:
        | 2026001
        | 2026002
        | 2027001
        |
        */

        $reservation = DB::transaction(function () use (
            $validated,
            $tour,
            $option,
            $schedule,
            $startAt,
            $endAt,
            $totalAmount,
            $depositPercentage,
            $depositAmount,
            $paymentDeadline
        ) {

            $year = Carbon::parse(
                $validated['booking_date']
            )->year;


            /*
            |--------------------------------------------------------------------------
            | Procurar a última reserva numerada desse ano
            |--------------------------------------------------------------------------
            */

            $lastReservationNumber = Reservation::query()
                ->whereNotNull('reservation_number')
                ->where(
                    'reservation_number',
                    'like',
                    $year . '%'
                )
                ->orderByDesc('reservation_number')
                ->lockForUpdate()
                ->value('reservation_number');


            /*
            |--------------------------------------------------------------------------
            | Calcular próximo número
            |--------------------------------------------------------------------------
            */

            $nextSequence = $lastReservationNumber
                ? ((int) substr($lastReservationNumber, 4)) + 1
                : 1;


            $reservationNumber = $year . str_pad(
                $nextSequence,
                3,
                '0',
                STR_PAD_LEFT
            );


            /*
            |--------------------------------------------------------------------------
            | Criar reserva
            |--------------------------------------------------------------------------
            */

            return Reservation::create([

                'reservation_number' => $reservationNumber,

                'tour_id' => $tour->id,

                'tour_option_id' => $option->id,

                'tour_option_schedule_id' => $schedule->id,

                'booking_date' => $validated['booking_date'],

                'start_at' => $startAt,

                'end_at' => $endAt,

                'participants' => $validated['participants'],

                'customer_name' => $validated['customer_name'],

                'customer_email' => $validated['customer_email'],

                'customer_phone' => $validated['customer_phone'],

                'customer_message' => $validated['customer_message'] ?? null,

                'locale' => Session::get('locale', config('app.locale')),

                'total_amount' => $totalAmount,

                'deposit_percentage' => $depositPercentage,

                'deposit_amount' => $depositAmount,

                'payment_deadline_at' => $paymentDeadline,

                'status' => 'pending_payment',

            ]);

        });


        /*
        |--------------------------------------------------------------------------
        | Enviar email de confirmação da reserva
        |--------------------------------------------------------------------------
        */

        Mail::to($reservation->customer_email)
            ->send(
                new ReservationCreated($reservation)
            );


        /*
        |--------------------------------------------------------------------------
        | Mostrar reserva ao cliente
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'reservations.show',
                $reservation->public_token
            );
    }


    /**
     * Verifica se um determinado horário do barco está disponível.
     */
    private function isSlotAvailable(
        string $bookingDate,
        string $startTime,
        string $endTime
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Intervalo escolhido
        |--------------------------------------------------------------------------
        */

        $bookingStart = $bookingDate . ' ' . $startTime;
        $bookingEnd = $bookingDate . ' ' . $endTime;


        /*
        |--------------------------------------------------------------------------
        | Verificar períodos bloqueados
        |--------------------------------------------------------------------------
        */

        $blockedPeriodExists = BlockedPeriod::query()
            ->where('start_at', '<', $bookingEnd)
            ->where('end_at', '>', $bookingStart)
            ->exists();


        if ($blockedPeriodExists) {
            return false;
        }


        /*
        |--------------------------------------------------------------------------
        | Verificar reservas existentes
        |--------------------------------------------------------------------------
        |
        | Temos um único barco.
        |
        | Qualquer reserva confirmada ou pending_payment
        | dentro do prazo ocupa o barco.
        |
        */

        $reservationExists = Reservation::query()
            ->where('booking_date', $bookingDate)
            ->where(function ($query) {

                $query
                    ->whereIn('status', [
                        'confirmed',
                    ])
                    ->orWhere(function ($query) {

                        $query
                            ->where('status', 'pending_payment')
                            ->where(
                                'payment_deadline_at',
                                '>',
                                now()
                            );

                    });

            })
            ->where('start_at', '<', $endTime)
            ->where('end_at', '>', $startTime)
            ->exists();


        if ($reservationExists) {
            return false;
        }


        return true;
    }


    /**
     * Mostra a reserva através do token público.
     */
    public function show(string $reservation)
    {
        $reservation = Reservation::where(
            'public_token',
            $reservation
        )->firstOrFail();


        $reservation->load([
            'tour.translations',
            'option.translations',
            'schedule',
        ]);


        return view(
            'pages.reservations.show',
            compact('reservation')
        );
    }


    /**
     * Recebe o comprovativo de pagamento enviado pelo cliente.
     */
    public function uploadPaymentProof(
        Request $request,
        Reservation $reservation
    ) {

        /*
        |--------------------------------------------------------------------------
        | Só aceitar comprovativo enquanto aguarda pagamento
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $reservation->status === 'pending_payment',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Validar ficheiro
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'payment_proof' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Guardar comprovativo
        |--------------------------------------------------------------------------
        |
        | O ficheiro fica no storage privado.
        |
        */

        $path = $validated['payment_proof']->store(
            'payment-proofs'
        );


        /*
        |--------------------------------------------------------------------------
        | Atualizar reserva
        |--------------------------------------------------------------------------
        */

        $reservation->update([

            'payment_proof' => $path,

            'payment_submitted_at' => now(),

            'status' => 'payment_submitted',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Voltar para a página da reserva
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'reservations.show',
                $reservation->public_token
            )
            ->with(
                'success',
                'O comprovativo foi enviado com sucesso. Obrigado.'
            );
    }


    /**
     * Cancela uma reserva pública ainda não paga.
     */
    public function cancel(Reservation $reservation)
    {

        /*
        |--------------------------------------------------------------------------
        | O cliente só pode cancelar enquanto aguarda pagamento
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $reservation->status === 'pending_payment',
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Cancelar reserva
        |--------------------------------------------------------------------------
        */

        $reservation->update([

            'status' => 'cancelled',

            'cancelled_at' => now(),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Voltar para a página da reserva
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'reservations.show',
                $reservation->public_token
            )
            ->with(
                'success',
                'A sua reserva foi cancelada com sucesso.'
            );
    }
}