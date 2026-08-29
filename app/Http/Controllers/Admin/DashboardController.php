<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlockedPeriod;
use App\Models\Gallery;
use App\Models\Reservation;
use App\Models\Tour;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Dashboard da administração.
     */
    public function index()
    {
        $today = Carbon::today();

        /*
        |--------------------------------------------------------------------------
        | Totais gerais
        |--------------------------------------------------------------------------
        */

        $totalTours = Tour::count();

        $totalReservations = Reservation::count();

        $totalGalleryItems = Gallery::count();

        $totalBlockedPeriods = BlockedPeriod::query()
            ->whereDate('end_at', '>=', $today)
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Reservas que precisam de atenção
        |--------------------------------------------------------------------------
        |
        | Estas são as reservas que interessam mais ao abrir o dashboard:
        |
        | - aguardam pagamento;
        | - têm comprovativo enviado e precisam de ser verificadas.
        |
        */

        $pendingPaymentCount = Reservation::query()
            ->where('status', 'pending_payment')
            ->count();

        $paymentSubmittedCount = Reservation::query()
            ->where('status', 'payment_submitted')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Estado das reservas
        |--------------------------------------------------------------------------
        */

        $confirmedReservationsCount = Reservation::query()
            ->where('status', 'confirmed')
            ->count();

        $cancelledReservationsCount = Reservation::query()
            ->where('status', 'cancelled')
            ->count();

        $rejectedReservationsCount = Reservation::query()
            ->where('status', 'rejected')
            ->count();

        $expiredReservationsCount = Reservation::query()
            ->where('status', 'expired')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Próximas reservas
        |--------------------------------------------------------------------------
        */

        $upcomingReservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
                'schedule',
            ])
            ->whereDate('booking_date', '>=', $today)
            ->whereNotIn('status', [
                'cancelled',
                'rejected',
                'expired',
            ])
            ->orderBy('booking_date')
            ->orderBy('start_at')
            ->orderBy('id')
            ->limit(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Últimas reservas
        |--------------------------------------------------------------------------
        */

        $latestReservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
                'schedule',
            ])
            ->latest('created_at')
            ->limit(6)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Reservas que exigem atenção
        |--------------------------------------------------------------------------
        */

        $attentionReservations = Reservation::query()
            ->with([
                'tour.translations',
                'option.translations',
                'schedule',
            ])
            ->whereIn('status', [
                'payment_submitted',
                'pending_payment',
            ])
            ->orderByRaw(
                "CASE
                    WHEN status = 'payment_submitted' THEN 0
                    WHEN status = 'pending_payment' THEN 1
                    ELSE 2
                END"
            )
            ->orderBy('booking_date')
            ->orderBy('id')
            ->limit(6)
            ->get();


        return view('admin.dashboard', [
            'totalTours' => $totalTours,
            'totalReservations' => $totalReservations,
            'totalGalleryItems' => $totalGalleryItems,
            'totalBlockedPeriods' => $totalBlockedPeriods,

            'pendingPaymentCount' => $pendingPaymentCount,
            'paymentSubmittedCount' => $paymentSubmittedCount,

            'confirmedReservationsCount' => $confirmedReservationsCount,
            'cancelledReservationsCount' => $cancelledReservationsCount,
            'rejectedReservationsCount' => $rejectedReservationsCount,
            'expiredReservationsCount' => $expiredReservationsCount,

            'upcomingReservations' => $upcomingReservations,
            'latestReservations' => $latestReservations,
            'attentionReservations' => $attentionReservations,
        ]);
    }
}