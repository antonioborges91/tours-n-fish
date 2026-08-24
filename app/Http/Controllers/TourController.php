<?php

namespace App\Http\Controllers;

use App\Models\BlockedPeriod;
use App\Models\Reservation;
use App\Models\Tour;
use Carbon\Carbon;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::query()
            ->where('available', true)
            ->with([
                'translations',
                'options.translations',
            ])
            ->orderBy('display_order')
            ->get();

        return view('pages.tours.index', compact('tours'));
    }

    public function show(Tour $tour)
    {
        $tour->load([
            'translations',
            'images',
            'options.translations',
            'options.schedules',
        ]);

        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Bloqueios globais
        |--------------------------------------------------------------------------
        */

        $blockedPeriods = BlockedPeriod::query()
            ->where('end_at', '>=', $today->copy()->startOfDay())
            ->orderBy('start_at')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Reservas que ocupam atualmente o barco
        |--------------------------------------------------------------------------
        |
        | O barco é um recurso único.
        |
        | Uma reserva ocupa o horário quando:
        |
        | - está confirmada;
        | OU
        | - está pendente de pagamento e o prazo ainda não expirou.
        |
        | Uma reserva pending_payment cujo prazo já expirou
        | deixa de ocupar o horário, mesmo antes de o seu estado
        | ser automaticamente alterado para expired.
        |
        */

        $reservations = Reservation::query()
            ->where('booking_date', '>=', $today->toDateString())
            ->where(function ($query) {

                $query
                    ->where('status', 'confirmed')

                    ->orWhere(function ($query) {

                        $query
                            ->where('status', 'pending_payment')
                            ->where('payment_deadline_at', '>', now());

                    });

            })
            ->orderBy('booking_date')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Datas que podem estar afetadas
        |--------------------------------------------------------------------------
        */

        $affectedDates = collect();

        /*
         * Datas afetadas pelos bloqueios.
         */

        foreach ($blockedPeriods as $blockedPeriod) {

            $startDate = $blockedPeriod->start_at
                ->copy()
                ->startOfDay();

            $endDate = $blockedPeriod->end_at
                ->copy()
                ->startOfDay();

            if ($endDate->lt($today)) {
                continue;
            }

            if ($startDate->lt($today)) {
                $startDate = $today->copy();
            }

            for (
                $date = $startDate->copy();
                $date->lte($endDate);
                $date->addDay()
            ) {
                $affectedDates->push(
                    $date->toDateString()
                );
            }
        }

        /*
         * Datas afetadas por reservas.
         */

        foreach ($reservations as $reservation) {

            $bookingDate = Carbon::parse(
                $reservation->booking_date
            );

            if ($bookingDate->lt($today)) {
                continue;
            }

            $affectedDates->push(
                $bookingDate->toDateString()
            );
        }

        $affectedDates = $affectedDates
            ->unique()
            ->sort()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Disponibilidade por horário
        |--------------------------------------------------------------------------
        |
        | Exemplo:
        |
        | [
        |     '2026-08-22' => [
        |         '1:1' => false,
        |         '1:2' => true,
        |         '2:3' => false,
        |     ],
        | ]
        |
        | true  = disponível
        | false = indisponível
        |
        */

        $scheduleAvailability = [];

        /*
        |--------------------------------------------------------------------------
        | Dias completamente indisponíveis
        |--------------------------------------------------------------------------
        */

        $unavailableDates = [];

        foreach ($affectedDates as $dateString) {

            $dateAvailability = [];

            foreach ($tour->options as $option) {

                foreach ($option->schedules as $schedule) {

                    $slotStart = Carbon::parse(
                        $dateString . ' ' . $schedule->start_time
                    );

                    $slotEnd = Carbon::parse(
                        $dateString . ' ' . $schedule->end_time
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Verificar bloqueios
                    |--------------------------------------------------------------------------
                    */

                    $blocked = $blockedPeriods->contains(
                        function ($blockedPeriod) use (
                            $slotStart,
                            $slotEnd
                        ) {
                            return $blockedPeriod->start_at < $slotEnd
                                && $blockedPeriod->end_at > $slotStart;
                        }
                    );

                    /*
                    |--------------------------------------------------------------------------
                    | Verificar reservas
                    |--------------------------------------------------------------------------
                    */

                    $reserved = $reservations->contains(
                        function ($reservation) use (
                            $dateString,
                            $slotStart,
                            $slotEnd
                        ) {
                            if (
                                Carbon::parse(
                                    $reservation->booking_date
                                )->toDateString() !== $dateString
                            ) {
                                return false;
                            }

                            /*
                             * Se a reserva não tiver horário definido,
                             * não conseguimos compará-la temporalmente.
                             */

                            if (
                                empty($reservation->start_at) ||
                                empty($reservation->end_at)
                            ) {
                                return false;
                            }

                            $reservationStart = Carbon::parse(
                                $dateString . ' ' . $reservation->start_at
                            );

                            $reservationEnd = Carbon::parse(
                                $dateString . ' ' . $reservation->end_at
                            );

                            return $reservationStart < $slotEnd
                                && $reservationEnd > $slotStart;
                        }
                    );

                    $available =
                        !$blocked &&
                        !$reserved;

                    $key =
                        $option->id . ':' . $schedule->id;

                    $dateAvailability[$key] =
                        $available;
                }
            }

            $scheduleAvailability[$dateString] =
                $dateAvailability;

            /*
            |--------------------------------------------------------------------------
            | O dia só fica indisponível se nenhum horário estiver disponível.
            |--------------------------------------------------------------------------
            */

            if (
                empty($dateAvailability) ||
                !in_array(true, $dateAvailability, true)
            ) {
                $unavailableDates[] = $dateString;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Página
        |--------------------------------------------------------------------------
        */

        return view(
            'pages.tours.show',
            compact(
                'tour',
                'unavailableDates',
                'scheduleAvailability'
            )
        );
    }
}