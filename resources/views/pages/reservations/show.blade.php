@php
    app()->setLocale($reservation->locale ?? config('app.locale'));
@endphp

@extends('layouts.app')

@section('title', __('reservation.success_title'))

@section('content')

<section class="reservation-show-page">

    <div class="container-custom">

        {{-- =========================================================
             HEADER
        ========================================================== --}}

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


        {{-- =========================================================
             RESERVATION CONTENT
        ========================================================== --}}

        <div class="reservation-show-layout">


            {{-- =====================================================
                 RESERVATION DETAILS
            ====================================================== --}}

            <div class="reservation-show-card">

                <div class="reservation-show-card-header">

                    <h2>
                        {{ __('reservation.reservation_data') }}
                    </h2>

                </div>


                <div class="reservation-show-details">


                    {{-- TOUR --}}

                    <div class="reservation-show-detail">

                        <span class="reservation-show-label">
                            {{ __('reservation.tour') }}
                        </span>

                        <strong>
                            {{ $reservation->tour->translation()?->name ?? '—' }}
                        </strong>

                    </div>


                    {{-- OPTION --}}

                    <div class="reservation-show-detail">

                        <span class="reservation-show-label">
                            {{ __('reservation.option') }}
                        </span>

                        <strong>
                            {{ $reservation->option->translation()?->name ?? '—' }}
                        </strong>

                    </div>


                    {{-- DATE --}}

                    <div class="reservation-show-detail">

                        <span class="reservation-show-label">
                            {{ __('reservation.date') }}
                        </span>

                        <strong>
                            {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d/m/Y') }}
                        </strong>

                    </div>


                    {{-- TIME --}}

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


                    {{-- PARTICIPANTS --}}

                    <div class="reservation-show-detail">

                        <span class="reservation-show-label">
                            {{ __('reservation.participants') }}
                        </span>

                        <strong>
                            {{ $reservation->participants }}
                        </strong>

                    </div>


                    {{-- RESERVATION NUMBER --}}

                    <div class="reservation-show-detail reservation-show-reservation-number">

                        <span class="reservation-show-label">
                            {{ __('reservation.reservation_number') }}
                        </span>

                        <strong>
                            #{{ $reservation->reservation_number }}
                        </strong>

                    </div>


                </div>

            </div>


            {{-- =====================================================
                 STATUS / PAYMENT
            ====================================================== --}}

            <div class="reservation-show-card">

                <div class="reservation-show-card-header">

                    <h2>
                        {{ __('reservation.reservation_status') }}
                    </h2>

                </div>


                {{-- STATUS --}}

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


                {{-- PAYMENT SUMMARY --}}

                <div class="reservation-show-payment">


                    {{-- TOTAL --}}

                    <div>

                        <span>
                            {{ __('reservation.tour_price') }}
                        </span>

                        <strong>
                            €{{ number_format(
                                (float) $reservation->total_amount,
                                2,
                                ',',
                                '.'
                            ) }}
                        </strong>

                    </div>


                    {{-- DEPOSIT --}}

                    <div>

                        <span>
                            {{ __('reservation.deposit') }}
                        </span>

                        <strong>
                            €{{ number_format(
                                (float) $reservation->deposit_amount,
                                2,
                                ',',
                                '.'
                            ) }}
                        </strong>

                    </div>


                    {{-- PAYMENT DEADLINE --}}

                    @if($reservation->payment_deadline_at)

                        <div>

                            <span>
                                {{ __('reservation.payment_deadline') }}
                            </span>

                            <strong>
                                {{ $reservation->payment_deadline_at->format('d/m/Y H:i') }}
                            </strong>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                     PENDING PAYMENT
                ================================================== --}}

                @if($reservation->status === 'pending_payment')


                    {{-- NEXT STEP --}}

                    <div class="reservation-show-notice">

                        <strong>
                            {{ __('reservation.next_step') }}
                        </strong>

                        <p>
                            {{ __('reservation.payment_instruction', [
                                'amount' => '€' . number_format(
                                    (float) $reservation->deposit_amount,
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


                    {{-- =================================================
                         BANK DETAILS
                    ================================================== --}}

                    <div class="reservation-show-bank">

                        <div class="reservation-show-bank-header">

                            <h3>
                                {{ __('reservation.bank_payment') }}
                            </h3>

                            <p>
                                {{ __('reservation.bank_payment_instruction') }}
                            </p>

                        </div>


                        <div class="reservation-show-bank-details">


                            {{-- ACCOUNT NAME --}}

                            <div>

                                <span>
                                    {{ __('reservation.account_name') }}
                                </span>

                                <strong>
                                    TOURS N FISH, LDA
                                </strong>

                            </div>


                            {{-- BANK --}}

                            <div>

                                <span>
                                    {{ __('reservation.bank_name') }}
                                </span>

                                <strong>
                                    NOME DO BANCO
                                </strong>

                            </div>


                            {{-- IBAN --}}

                            <div>

                                <span>
                                    IBAN
                                </span>

                                <strong>
                                    PT50 0000 0000 0000 0000 0000 0
                                </strong>

                            </div>


                            {{-- SWIFT --}}

                            <div>

                                <span>
                                    SWIFT / BIC
                                </span>

                                <strong>
                                    XXXXXXXXXXX
                                </strong>

                            </div>


                            {{-- PAYMENT REFERENCE --}}

                            <div>

                                <span>
                                    {{ __('reservation.payment_reference') }}
                                </span>

                                <strong>
                                    #{{ $reservation->reservation_number }}
                                </strong>

                            </div>


                        </div>


                        {{-- BANK NOTE --}}

                        <div class="reservation-show-bank-note">

                            {{ __('reservation.bank_payment_note') }}

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</section>

@endsection