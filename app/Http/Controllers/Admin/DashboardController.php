<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedPeriod;
use App\Models\Reservation;
use App\Models\Tour;

class DashboardController extends Controller
{
    /**
     * Dashboard da administração.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Resumo
        |--------------------------------------------------------------------------
        */

        $toursCount = Tour::query()
            ->where('available', true)
            ->count();

        $reservationsCount = Reservation::query()
            ->count();

        $pendingPaymentCount = Reservation::query()
            ->where('status', 'pending_payment')
            ->count();

        $paymentSubmittedCount = Reservation::query()
            ->where('status', 'payment_submitted')
            ->count();

        $confirmedCount = Reservation::query()
            ->where('status', 'confirmed')
            ->count();

        $cancelledCount = Reservation::query()
            ->where('status', 'cancelled')
            ->count();

        $expiredCount = Reservation::query()
            ->where('status', 'expired')
            ->count();

        $activeBlockedPeriodsCount = BlockedPeriod::query()
            ->where('end_at', '>=', now())
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Reservas que precisam de atenção
        |--------------------------------------------------------------------------
        |
        | O caso mais importante para o administrador é quando o cliente
        | enviou o comprovativo e está à espera de verificação.
        |
        */

        $attentionReservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
            ])
            ->where('status', 'payment_submitted')
            ->orderByDesc('payment_submitted_at')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Próximas reservas confirmadas
        |--------------------------------------------------------------------------
        */

        $upcomingReservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
            ])
            ->where('status', 'confirmed')
            ->whereDate('booking_date', '>=', today())
            ->orderBy('booking_date')
            ->orderBy('start_at')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Dados para a view
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', [

            'toursCount' => $toursCount,

            'reservationsCount' => $reservationsCount,

            'pendingPaymentCount' => $pendingPaymentCount,

            'paymentSubmittedCount' => $paymentSubmittedCount,

            'confirmedCount' => $confirmedCount,

            'cancelledCount' => $cancelledCount,

            'expiredCount' => $expiredCount,

            'activeBlockedPeriodsCount' => $activeBlockedPeriodsCount,

            'attentionReservations' => $attentionReservations,

            'upcomingReservations' => $upcomingReservations,

        ]);
    }
}