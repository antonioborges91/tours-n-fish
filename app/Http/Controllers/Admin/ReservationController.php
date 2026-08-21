<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;

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
            ->orderByDesc('booking_date')
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
}