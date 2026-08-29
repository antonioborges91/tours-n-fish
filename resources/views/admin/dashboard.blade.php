@extends('layouts.admin')

@section('content')

<div class="admin-dashboard">

    {{-- =========================================================
         CABEÇALHO
    ========================================================== --}}

    <div class="admin-dashboard-header">

        <div>

            <span class="admin-dashboard-kicker">
                Administração
            </span>

            <h1>
                Dashboard
            </h1>

            <p>
                Visão geral das reservas, passeios e atividade da empresa.
            </p>

        </div>

    </div>


    {{-- =========================================================
         INDICADORES PRINCIPAIS
    ========================================================== --}}

    <section class="admin-dashboard-stats">

        <a
            href="{{ route('admin.tours.index') }}"
            class="admin-dashboard-stat"
        >

            <div class="admin-dashboard-stat-top">

                <span class="admin-dashboard-stat-label">
                    Passeios ativos
                </span>

                <span class="admin-dashboard-stat-icon">
                    →
                </span>

            </div>

            <strong class="admin-dashboard-stat-value">
                {{ $toursCount }}
            </strong>

        </a>


        <a
            href="{{ route('admin.reservations.index') }}"
            class="admin-dashboard-stat"
        >

            <div class="admin-dashboard-stat-top">

                <span class="admin-dashboard-stat-label">
                    Reservas
                </span>

                <span class="admin-dashboard-stat-icon">
                    →
                </span>

            </div>

            <strong class="admin-dashboard-stat-value">
                {{ $reservationsCount }}
            </strong>

        </a>


        <a
            href="{{ route('admin.reservations.index') }}"
            class="admin-dashboard-stat admin-dashboard-stat-warning"
        >

            <div class="admin-dashboard-stat-top">

                <span class="admin-dashboard-stat-label">
                    Comprovativos por verificar
                </span>

                <span class="admin-dashboard-stat-icon">
                    !
                </span>

            </div>

            <strong class="admin-dashboard-stat-value">
                {{ $paymentSubmittedCount }}
            </strong>

        </a>


        <a
            href="{{ route('admin.blocked-periods.index') }}"
            class="admin-dashboard-stat"
        >

            <div class="admin-dashboard-stat-top">

                <span class="admin-dashboard-stat-label">
                    Bloqueios ativos
                </span>

                <span class="admin-dashboard-stat-icon">
                    →
                </span>

            </div>

            <strong class="admin-dashboard-stat-value">
                {{ $activeBlockedPeriodsCount }}
            </strong>

        </a>

    </section>


    {{-- =========================================================
         CONTEÚDO PRINCIPAL
    ========================================================== --}}

    <div class="admin-dashboard-grid">


        {{-- =====================================================
             RESERVAS A AGUARDAR ATENÇÃO
        ====================================================== --}}

        <section class="admin-dashboard-card">

            <div class="admin-dashboard-card-header">

                <div>

                    <span class="admin-dashboard-card-label">
                        Ação necessária
                    </span>

                    <h2>
                        Comprovativos por verificar
                    </h2>

                </div>

                <a
                    href="{{ route('admin.reservations.index') }}"
                    class="admin-dashboard-card-link"
                >
                    Ver reservas
                </a>

            </div>


            @if($attentionReservations->isNotEmpty())

                <div class="admin-dashboard-list">

                    @foreach($attentionReservations as $reservation)

                        @php
                            $tourTranslation = $reservation->tour?->translation();
                            $optionTranslation = $reservation->option?->translation();
                        @endphp

                        <a
                            href="{{ route('admin.reservations.show', $reservation) }}"
                            class="admin-dashboard-list-item"
                        >

                            <div class="admin-dashboard-list-main">

                                <strong>
                                    #{{ $reservation->reservation_number }}
                                </strong>

                                <span>
                                    {{ $reservation->customer_name }}
                                </span>

                                <small>

                                    {{ $tourTranslation?->name ?? 'Passeio' }}

                                    @if($optionTranslation?->name)
                                        · {{ $optionTranslation->name }}
                                    @endif

                                </small>

                            </div>


                            <div class="admin-dashboard-list-side">

                                <span class="admin-status admin-status-payment_submitted">
                                    Comprovativo enviado
                                </span>

                                @if($reservation->payment_submitted_at)

                                    <small>
                                        {{ $reservation->payment_submitted_at->format('d/m/Y H:i') }}
                                    </small>

                                @endif

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="admin-dashboard-empty">

                    <strong>
                        Não existem comprovativos pendentes.
                    </strong>

                    <p>
                        Quando um cliente enviar um comprovativo,
                        a reserva aparecerá aqui.
                    </p>

                </div>

            @endif

        </section>


        {{-- =====================================================
             PRÓXIMAS RESERVAS
        ====================================================== --}}

        <section class="admin-dashboard-card">

            <div class="admin-dashboard-card-header">

                <div>

                    <span class="admin-dashboard-card-label">
                        Agenda
                    </span>

                    <h2>
                        Próximos passeios
                    </h2>

                </div>

                <a
                    href="{{ route('admin.reservations.index') }}"
                    class="admin-dashboard-card-link"
                >
                    Ver reservas
                </a>

            </div>


            @if($upcomingReservations->isNotEmpty())

                <div class="admin-dashboard-list">

                    @foreach($upcomingReservations as $reservation)

                        @php
                            $tourTranslation = $reservation->tour?->translation();
                            $optionTranslation = $reservation->option?->translation();
                        @endphp

                        <a
                            href="{{ route('admin.reservations.show', $reservation) }}"
                            class="admin-dashboard-list-item"
                        >

                            <div class="admin-dashboard-date">

                                <strong>
                                    {{ $reservation->booking_date->format('d') }}
                                </strong>

                                <span>
                                    {{ mb_strtoupper(
                                        $reservation->booking_date->translatedFormat('M')
                                    ) }}
                                </span>

                            </div>


                            <div class="admin-dashboard-list-main">

                                <strong>
                                    {{ $tourTranslation?->name ?? 'Passeio' }}
                                </strong>

                                <span>
                                    {{ $reservation->customer_name }}
                                </span>

                                <small>

                                    {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}

                                    -

                                    {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}

                                    ·

                                    {{ $reservation->participants }}
                                    {{ $reservation->participants === 1 ? 'pessoa' : 'pessoas' }}

                                    @if($optionTranslation?->name)
                                        · {{ $optionTranslation->name }}
                                    @endif

                                </small>

                            </div>


                            <div class="admin-dashboard-list-side">

                                <span class="admin-status admin-status-confirmed">
                                    Confirmada
                                </span>

                            </div>

                        </a>

                    @endforeach

                </div>

            @else

                <div class="admin-dashboard-empty">

                    <strong>
                        Não existem reservas confirmadas próximas.
                    </strong>

                    <p>
                        As próximas reservas confirmadas aparecerão aqui.
                    </p>

                </div>

            @endif

        </section>

    </div>


    {{-- =========================================================
         ESTADO DAS RESERVAS
    ========================================================== --}}

    <section class="admin-dashboard-card admin-dashboard-status-card">

        <div class="admin-dashboard-card-header">

            <div>

                <span class="admin-dashboard-card-label">
                    Reservas
                </span>

                <h2>
                    Estado das reservas
                </h2>

            </div>

            <a
                href="{{ route('admin.reservations.index') }}"
                class="admin-dashboard-card-link"
            >
                Gerir reservas
            </a>

        </div>


        <div class="admin-dashboard-status-grid">


            <div class="admin-dashboard-status-item">

                <span class="admin-status admin-status-pending_payment">
                    A aguardar pagamento
                </span>

                <strong>
                    {{ $pendingPaymentCount }}
                </strong>

            </div>


            <div class="admin-dashboard-status-item">

                <span class="admin-status admin-status-payment_submitted">
                    Comprovativo enviado
                </span>

                <strong>
                    {{ $paymentSubmittedCount }}
                </strong>

            </div>


            <div class="admin-dashboard-status-item">

                <span class="admin-status admin-status-confirmed">
                    Confirmadas
                </span>

                <strong>
                    {{ $confirmedCount }}
                </strong>

            </div>


            <div class="admin-dashboard-status-item">

                <span class="admin-status admin-status-cancelled">
                    Canceladas
                </span>

                <strong>
                    {{ $cancelledCount }}
                </strong>

            </div>


            <div class="admin-dashboard-status-item">

                <span class="admin-status admin-status-expired">
                    Expiradas
                </span>

                <strong>
                    {{ $expiredCount }}
                </strong>

            </div>

        </div>

    </section>

</div>

@endsection