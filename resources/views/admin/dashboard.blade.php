@extends('layouts.admin')

@section('content')

<div class="admin-dashboard">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="admin-page-header">

        <div>
            <h1 class="admin-page-title">
                Dashboard
            </h1>

            <p class="admin-page-description">
                Visão geral da atividade e das reservas.
            </p>
        </div>

    </div>


    {{-- =========================================================
         ALERTA DE ATENÇÃO
    ========================================================== --}}

    @if ($paymentSubmittedCount > 0)

        <a
            href="{{ route('admin.reservations.index', ['status' => 'payment_submitted']) }}"
            class="admin-dashboard-alert admin-dashboard-alert-payment"
        >

            <div class="admin-dashboard-alert-icon">
                !
            </div>

            <div class="admin-dashboard-alert-content">

                <strong>
                    {{ $paymentSubmittedCount }}
                    {{ $paymentSubmittedCount === 1
                        ? 'reserva tem um comprovativo'
                        : 'reservas têm comprovativo'
                    }}
                    para verificar
                </strong>

                <span>
                    Existem pagamentos submetidos pelos clientes que aguardam confirmação.
                </span>

            </div>

            <span class="admin-dashboard-alert-action">
                Ver reservas →
            </span>

        </a>

    @endif


    {{-- =========================================================
         INDICADORES PRINCIPAIS
    ========================================================== --}}

    <section class="admin-dashboard-stats">

        <a
            href="{{ route('admin.tours.index') }}"
            class="admin-dashboard-stat"
        >

            <span class="admin-dashboard-stat-label">
                Passeios
            </span>

            <strong class="admin-dashboard-stat-value">
                {{ $totalTours }}
            </strong>

            <span class="admin-dashboard-stat-link">
                Gerir passeios →
            </span>

        </a>


        <a
            href="{{ route('admin.reservations.index') }}"
            class="admin-dashboard-stat"
        >

            <span class="admin-dashboard-stat-label">
                Reservas
            </span>

            <strong class="admin-dashboard-stat-value">
                {{ $totalReservations }}
            </strong>

            <span class="admin-dashboard-stat-link">
                Ver reservas →
            </span>

        </a>


        <a
            href="{{ route('admin.gallery.index') }}"
            class="admin-dashboard-stat"
        >

            <span class="admin-dashboard-stat-label">
                Galeria
            </span>

            <strong class="admin-dashboard-stat-value">
                {{ $totalGalleryItems }}
            </strong>

            <span class="admin-dashboard-stat-link">
                Gerir galeria →
            </span>

        </a>


        <a
            href="{{ route('admin.blocked-periods.index') }}"
            class="admin-dashboard-stat"
        >

            <span class="admin-dashboard-stat-label">
                Bloqueios ativos
            </span>

            <strong class="admin-dashboard-stat-value">
                {{ $totalBlockedPeriods }}
            </strong>

            <span class="admin-dashboard-stat-link">
                Gerir bloqueios →
            </span>

        </a>

    </section>


    {{-- =========================================================
         RESUMO DAS RESERVAS
    ========================================================== --}}

    <section class="admin-dashboard-section">

        <div class="admin-dashboard-section-header">

            <div>
                <span class="admin-dashboard-section-label">
                    Reservas
                </span>

                <h2>
                    Estado atual
                </h2>
            </div>

            <a
                href="{{ route('admin.reservations.index') }}"
                class="admin-dashboard-section-link"
            >
                Ver todas
            </a>

        </div>


        <div class="admin-dashboard-status-grid">

            <a
                href="{{ route('admin.reservations.index', ['status' => 'pending_payment']) }}"
                class="admin-dashboard-status-card status-payment"
            >
                <span>
                    A aguardar pagamento
                </span>

                <strong>
                    {{ $pendingPaymentCount }}
                </strong>
            </a>


            <a
                href="{{ route('admin.reservations.index', ['status' => 'payment_submitted']) }}"
                class="admin-dashboard-status-card status-submitted"
            >
                <span>
                    Comprovativo enviado
                </span>

                <strong>
                    {{ $paymentSubmittedCount }}
                </strong>
            </a>


            <a
                href="{{ route('admin.reservations.index', ['status' => 'confirmed']) }}"
                class="admin-dashboard-status-card status-confirmed"
            >

                <span>
                    Confirmadas
                </span>

                <strong>
                    {{ $confirmedReservationsCount }}
                </strong>

            </a>


            <a
                href="{{ route('admin.reservations.index', ['status' => 'cancelled']) }}"
                class="admin-dashboard-status-card status-cancelled"
            >

                <span>
                    Canceladas
                </span>

                <strong>
                    {{ $cancelledReservationsCount }}
                </strong>

            </a>


            <a
                href="{{ route('admin.reservations.index', ['status' => 'rejected']) }}"
                class="admin-dashboard-status-card status-rejected"
            >

                <span>
                    Rejeitadas
                </span>

                <strong>
                    {{ $rejectedReservationsCount }}
                </strong>

            </a>


            <a
                href="{{ route('admin.reservations.index', ['status' => 'expired']) }}"
                class="admin-dashboard-status-card status-expired"
            >

                <span>
                    Expiradas
                </span>

                <strong>
                    {{ $expiredReservationsCount }}
                </strong>

            </a>

        </div>

    </section>


    {{-- =========================================================
         DUAS COLUNAS
    ========================================================== --}}

    <div class="admin-dashboard-columns">


        {{-- =====================================================
             RESERVAS QUE EXIGEM ATENÇÃO
        ====================================================== --}}

        <section class="admin-dashboard-panel">

            <div class="admin-dashboard-panel-header">

                <div>
                    <span class="admin-dashboard-section-label">
                        Atenção
                    </span>

                    <h2>
                        Reservas a tratar
                    </h2>
                </div>

                <a
                    href="{{ route('admin.reservations.index') }}"
                    class="admin-dashboard-section-link"
                >
                    Ver todas
                </a>

            </div>


            @if ($attentionReservations->isEmpty())

                <div class="admin-dashboard-empty">
                    <strong>
                        Tudo tratado.
                    </strong>

                    <span>
                        Não existem reservas pendentes de intervenção.
                    </span>
                </div>

            @else

                <div class="admin-dashboard-reservation-list">

                    @foreach ($attentionReservations as $reservation)

                        @php
                            $tourTranslation = $reservation->tour?->translations
                                ?->firstWhere('locale', app()->getLocale());

                            $optionTranslation = $reservation->option?->translations
                                ?->firstWhere('locale', app()->getLocale());

                            $statusLabels = [
                                'pending_payment' => 'A aguardar pagamento',
                                'payment_submitted' => 'Comprovativo enviado',
                                'confirmed' => 'Confirmada',
                                'rejected' => 'Rejeitada',
                                'cancelled' => 'Cancelada',
                                'expired' => 'Expirada',
                            ];
                        @endphp

                        <a
                            href="{{ route('admin.reservations.show', $reservation) }}"
                            class="admin-dashboard-reservation"
                        >

                            <div class="admin-dashboard-reservation-main">

                                <strong>
                                    #{{ $reservation->reservation_number ?? $reservation->id }}
                                </strong>

                                <span>
                                    {{ $tourTranslation?->name ?? '—' }}
                                </span>

                                <small>
                                    {{ $reservation->customer_name }}
                                </small>

                            </div>


                            <div class="admin-dashboard-reservation-meta">

                                <strong>
                                    {{ $reservation->booking_date?->format('d/m/Y') ?? '—' }}
                                </strong>

                                <span>
                                    {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}
                                </span>

                            </div>


                            <span class="admin-status admin-status-{{ $reservation->status }}">
                                {{ $statusLabels[$reservation->status] ?? $reservation->status }}
                            </span>

                        </a>

                    @endforeach

                </div>

            @endif

        </section>


        {{-- =====================================================
             PRÓXIMAS RESERVAS
        ====================================================== --}}

        <section class="admin-dashboard-panel">

            <div class="admin-dashboard-panel-header">

                <div>
                    <span class="admin-dashboard-section-label">
                        Agenda
                    </span>

                    <h2>
                        Próximas reservas
                    </h2>
                </div>

                <a
                    href="{{ route('admin.reservations.index') }}"
                    class="admin-dashboard-section-link"
                >
                    Ver todas
                </a>

            </div>


            @if ($upcomingReservations->isEmpty())

                <div class="admin-dashboard-empty">

                    <strong>
                        Não existem próximas reservas.
                    </strong>

                    <span>
                        As novas reservas aparecerão aqui.
                    </span>

                </div>

            @else

                <div class="admin-dashboard-reservation-list">

                    @foreach ($upcomingReservations as $reservation)

                        @php
                            $tourTranslation = $reservation->tour?->translations
                                ?->firstWhere('locale', app()->getLocale());
                        @endphp

                        <a
                            href="{{ route('admin.reservations.show', $reservation) }}"
                            class="admin-dashboard-reservation"
                        >

                            <div class="admin-dashboard-reservation-date">

                                <strong>
                                    {{ $reservation->booking_date?->format('d') }}
                                </strong>

                                <span>
                                    {{ $reservation->booking_date?->translatedFormat('M') }}
                                </span>

                            </div>


                            <div class="admin-dashboard-reservation-main">

                                <strong>
                                    {{ $tourTranslation?->name ?? '—' }}
                                </strong>

                                <span>
                                    {{ $reservation->customer_name }}
                                </span>

                                <small>
                                    {{ $reservation->participants }}
                                    {{ $reservation->participants === 1 ? 'pessoa' : 'pessoas' }}
                                    ·
                                    {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}
                                </small>

                            </div>


                            <span class="admin-dashboard-reservation-arrow">
                                →
                            </span>

                        </a>

                    @endforeach

                </div>

            @endif

        </section>

    </div>


    {{-- =========================================================
         ÚLTIMAS RESERVAS
    ========================================================== --}}

    <section class="admin-dashboard-panel admin-dashboard-latest">

        <div class="admin-dashboard-panel-header">

            <div>
                <span class="admin-dashboard-section-label">
                    Atividade
                </span>

                <h2>
                    Últimas reservas
                </h2>
            </div>

            <a
                href="{{ route('admin.reservations.index') }}"
                class="admin-dashboard-section-link"
            >
                Ver todas
            </a>

        </div>


        <div class="admin-dashboard-latest-list">

            @foreach ($latestReservations as $reservation)

                @php
                    $tourTranslation = $reservation->tour?->translations
                        ?->firstWhere('locale', app()->getLocale());

                    $statusLabels = [
                        'pending_payment' => 'A aguardar pagamento',
                        'payment_submitted' => 'Comprovativo enviado',
                        'confirmed' => 'Confirmada',
                        'rejected' => 'Rejeitada',
                        'cancelled' => 'Cancelada',
                        'expired' => 'Expirada',
                    ];
                @endphp

                <a
                    href="{{ route('admin.reservations.show', $reservation) }}"
                    class="admin-dashboard-latest-row"
                >

                    <span class="admin-dashboard-latest-number">
                        #{{ $reservation->reservation_number ?? $reservation->id }}
                    </span>

                    <span class="admin-dashboard-latest-tour">
                        {{ $tourTranslation?->name ?? '—' }}
                    </span>

                    <span class="admin-dashboard-latest-customer">
                        {{ $reservation->customer_name }}
                    </span>

                    <span class="admin-dashboard-latest-date">
                        {{ $reservation->created_at?->format('d/m/Y H:i') ?? '—' }}
                    </span>

                    <span class="admin-status admin-status-{{ $reservation->status }}">
                        {{ $statusLabels[$reservation->status] ?? $reservation->status }}
                    </span>

                </a>

            @endforeach

        </div>

    </section>

</div>

@endsection