<?php

namespace App\Http\Controllers;

use App\Models\BlockedPeriod;
use App\Models\Reservation;
use App\Models\Tour;
use App\Models\TourOption;
use App\Models\TourOptionSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Apresenta o formulário de reserva.
     */
    public function create(
        Tour $tour,
        TourOption $option,
        TourOptionSchedule $schedule
    ) {
        /*
        |--------------------------------------------------------------------------
        | Validar relações
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $option->tour_id === $tour->id,
            404
        );

        abort_unless(
            $schedule->tour_option_id === $option->id,
            404
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
        | Carregar traduções
        |--------------------------------------------------------------------------
        */

        $tour->load('translations');
        $option->load('translations');

        /*
        |--------------------------------------------------------------------------
        | Preparar calendário
        |--------------------------------------------------------------------------
        |
        | Mostramos os próximos 12 meses.
        |
        */

        $calendarStart = Carbon::today();
        $calendarEnd = $calendarStart->copy()->addYear();

        $availableDates = [];
        $unavailableDates = [];

        $currentDate = $calendarStart->copy();

        while ($currentDate->lte($calendarEnd)) {

            $date = $currentDate->format('Y-m-d');

            if ($this->isSlotAvailable(
                $date,
                $schedule->start_time,
                $schedule->end_time
            )) {
                $availableDates[] = $date;
            } else {
                $unavailableDates[] = $date;
            }

            $currentDate->addDay();
        }

        return view(
            'pages.reservations.create',
            compact(
                'tour',
                'option',
                'schedule',
                'availableDates',
                'unavailableDates'
            )
        );
    }


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
        | Verificar disponibilidade
        |--------------------------------------------------------------------------
        |
        | O cliente nunca envia start_at/end_at.
        | Estes valores vêm sempre do schedule escolhido.
        |
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
        | Criar reserva
        |--------------------------------------------------------------------------
        */

        $reservation = Reservation::create([

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

            'total_amount' => $totalAmount,

            'deposit_percentage' => $depositPercentage,

            'deposit_amount' => $depositAmount,

            'status' => 'pending_payment',

        ]);


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
        | Qualquer reserva não cancelada que se sobreponha
        | ocupa o barco nesse intervalo.
        |
        */

        $reservationExists = Reservation::query()
            ->where('booking_date', $bookingDate)
            ->whereNotIn('status', [
                'cancelled',
            ])
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
}