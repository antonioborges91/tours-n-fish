<?php

namespace App\Http\Controllers;

use App\Models\Tour;
use App\Models\TourOption;
use App\Models\TourOptionSchedule;

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

        return view(
            'pages.reservations.create',
            compact(
                'tour',
                'option',
                'schedule'
            )
        );
    }
}