<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Support\Facades\Storage;

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