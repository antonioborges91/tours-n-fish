@php
    app()->setLocale($reservation->locale ?? config('app.locale'));
@endphp

@extends('layouts.app')

@section('title', __('reservation.success_title'))

@section('content')

<section class="reservation-show-page">

    <div class="container-custom">

        {{-- Cabeçalho --}}
        <div class="reservation-show-header">

            <div class="reservation-show-icon">
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


        {{-- Informação da reserva --}}
        <div class="reservation-show-layout">

            {{-- Dados da reserva --}}
            <div class="reservation-show-card">

                <div class="reservation-show-card-header">
                    <h2>
                        {{ __('reservation.reservation_data') }}
                    </h2>
                </div>

                <div class="reservation-show-details">

                    {{-- Tour --}}
                    <div class="reservation-show-detail">
                        <span class="reservation-show-label">
                            {{ __('reservation.tour') }}
                        </span>

                        <strong>
                            {{ $reservation->tour->translation()->name }}
                        </strong>
                    </div>

                    {{-- Option --}}
                    <div class="reservation-show-detail">
                        <span class="reservation-show-label">
                            {{ __('reservation.option') }}
                        </span>

                        <strong>
                            {{ $reservation->option->translation()->name }}
                        </strong>
                    </div>

                    {{-- Date --}}
                    <div class="reservation-show-detail">
                        <span class="reservation-show-label">
                            {{ __('reservation.date') }}
                        </span>

                        <strong>
                            {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d/m/Y') }}
                        </strong>
                    </div>

                    {{-- Time --}}
                    <div class="reservation-show-detail">
                        <span class="reservation-show-label">
                            {{ __('reservation.time') }}
                        </span>

                        <strong>
                            {{ substr($reservation->start_at, 0, 5) }}
                            —
                            {{ substr($reservation->end_at, 0, 5) }}
                        </strong>
                    </div>

                    {{-- Participants --}}
                    <div class="reservation-show-detail">
                        <span class="reservation-show-label">
                            {{ __('reservation.participants') }}
                        </span>

                        <strong>
                            {{ $reservation->participants }}
                        </strong>
                    </div>

                </div>

                {{-- Número da reserva --}}
                <div class="reservation-show-number">

                    <span>
                        {{ __('reservation.reservation_number') }}
                    </span>

                    <strong>
                        #{{ $reservation->reservation_number }}
                    </strong>

                </div>

            </div>


            {{-- Estado e pagamento --}}
            <div class="reservation-show-card">

                <div class="reservation-show-card-header">
                    <h2>
                        {{ __('reservation.reservation_status') }}
                    </h2>
                </div>


                <div class="reservation-show-status">

                    @if($reservation->status === 'pending_payment')

                        <span class="reservation-show-status-badge pending">
                            {{ __('reservation.pending_payment') }}
                        </span>

                    @elseif($reservation->status === 'confirmed')

                        <span class="reservation-show-status-badge confirmed">
                            {{ __('reservation.confirmed') }}
                        </span>

                    @elseif($reservation->status === 'cancelled')

                        <span class="reservation-show-status-badge cancelled">
                            {{ __('reservation.cancelled') }}
                        </span>

                    @endif

                </div>


                <div class="reservation-show-payment">

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

                    <div class="reservation-show-notice">

                        <strong>
                            {{ __('reservation.next_step') }}
                        </strong>

                        <p>
                            {{ __('reservation.payment_instruction', [
                                'amount' => '€' . number_format(
                                    $reservation->deposit_amount,
                                    2,
                                    ',',
                                    '.'
                                )
                            ]) }}
                        </p>

                        <p>
                            {{ __('reservation.proof_instruction') }}
                        </p>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

@endsection