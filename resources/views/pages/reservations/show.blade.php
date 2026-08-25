@php
    app()->setLocale($reservation->locale ?? config('app.locale'));
@endphp

@extends('layouts.app')

@section('title', __('reservation.success_title'))

@section('content')

<section class="reservation-page">

    <div class="container-custom">

        <div class="reservation-success">

            <div class="reservation-success-icon">
                ✓
            </div>

            <h1>
                {{ __('reservation.success_title') }}
            </h1>

            <p>
                {{ __('reservation.success_message', [
                    'name' => $reservation->customer_name
                ]) }}
            </p>

        </div>


        <div class="reservation-layout">

            {{-- Dados da reserva --}}

            <div class="reservation-card">

                <div class="reservation-card-header">

                    <h2>
                        {{ __('reservation.reservation_data') }}
                    </h2>

                </div>


                <div class="reservation-details">

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            {{ __('reservation.tour') }}
                        </span>

                        <strong>
                            {{ $reservation->tour->translation()->name }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            {{ __('reservation.option') }}
                        </span>

                        <strong>
                            {{ $reservation->option->translation()->name }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            {{ __('reservation.date') }}
                        </span>

                        <strong>
                            {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d/m/Y') }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            {{ __('reservation.time') }}
                        </span>

                        <strong>
                            {{ substr($reservation->start_at, 0, 5) }}
                            —
                            {{ substr($reservation->end_at, 0, 5) }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            {{ __('reservation.participants') }}
                        </span>

                        <strong>
                            {{ $reservation->participants }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Estado e pagamento --}}

            <div class="reservation-card">

                <div class="reservation-card-header">

                    <h2>
                        {{ __('reservation.reservation_status') }}
                    </h2>

                </div>


                <div class="reservation-status">

                    @if($reservation->status === 'pending_payment')

                        <span class="reservation-status-badge pending">
                            {{ __('reservation.pending_payment') }}
                        </span>

                    @elseif($reservation->status === 'confirmed')

                        <span class="reservation-status-badge confirmed">
                            {{ __('reservation.confirmed') }}
                        </span>

                    @elseif($reservation->status === 'cancelled')

                        <span class="reservation-status-badge cancelled">
                            {{ __('reservation.cancelled') }}
                        </span>

                    @endif

                </div>


                <div class="reservation-payment">

                    <div>

                        <span>
                            {{ __('reservation.tour_price') }}
                        </span>

                        <strong>
                            €{{ number_format($reservation->total_amount, 2, ',', '.') }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            {{ __('reservation.deposit') }}
                        </span>

                        <strong>
                            €{{ number_format($reservation->deposit_amount, 2, ',', '.') }}
                        </strong>

                    </div>

                </div>


                @if($reservation->status === 'pending_payment')

                    <div class="reservation-notice">

                        <strong>
                            {{ __('reservation.next_step') }}
                        </strong>

                        <p>
                            {{ __('reservation.payment_instruction', [
                                'amount' => '€' . number_format($reservation->deposit_amount, 2, ',', '.')
                            ]) }}
                        </p>

                        <p>
                            {{ __('reservation.proof_instruction') }}
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Referência pública --}}

        <div class="reservation-reference">

            <span>
                {{ __('reservation.reservation_reference') }}
            </span>

            <strong>
                {{ $reservation->public_token }}
            </strong>

        </div>

    </div>

</section>


@push('styles')

<style>

.reservation-success {
    text-align: center;
    margin-bottom: 40px;
}

.reservation-success-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #dcfce7;
    color: #15803d;

    font-size: 30px;
    font-weight: 700;
}

.reservation-success h1 {
    margin: 0;

    font-size: 2.2rem;
    font-weight: 700;
}

.reservation-success p {
    margin-top: 10px;

    color: #6b7280;
    font-size: 1.05rem;
}

.reservation-status {
    margin-bottom: 25px;
}

.reservation-status-badge {
    display: inline-block;

    padding: 8px 14px;

    border-radius: 999px;

    font-size: 0.9rem;
    font-weight: 600;
}

.reservation-status-badge.pending {
    background: #fff7d6;
    color: #92400e;
}

.reservation-status-badge.confirmed {
    background: #dcfce7;
    color: #15803d;
}

.reservation-status-badge.cancelled {
    background: #fee2e2;
    color: #b91c1c;
}

.reservation-reference {
    margin-top: 25px;

    text-align: center;

    color: #6b7280;
}

.reservation-reference strong {
    display: block;

    margin-top: 5px;

    color: #374151;

    font-size: 0.85rem;

    word-break: break-all;
}

</style>

@endpush

@endsection