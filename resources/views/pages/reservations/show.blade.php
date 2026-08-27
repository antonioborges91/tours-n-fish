@php
    app()->setLocale($reservation->locale ?? config('app.locale'));

    $isPendingPayment = $reservation->status === 'pending_payment';
    $isPaymentSubmitted = $reservation->status === 'payment_submitted';
    $isConfirmed = $reservation->status === 'confirmed';
    $isCancelled = $reservation->status === 'cancelled';

    $tourName = $reservation->tour?->translation()?->name ?? '—';
    $optionName = $reservation->option?->translation()?->name ?? '—';

    $totalAmount = number_format(
        (float) $reservation->total_amount,
        2,
        ',',
        '.'
    );

    $depositAmount = number_format(
        (float) $reservation->deposit_amount,
        2,
        ',',
        '.'
    );
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
             MAIN CONTENT
        ========================================================== --}}

        <div class="reservation-show-layout">


            {{-- =====================================================
                 LEFT COLUMN
                 RESERVATION + BANK DETAILS
            ====================================================== --}}

            <div class="reservation-show-column">


                {{-- =================================================
                     RESERVATION DATA
                ================================================== --}}

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
                                {{ $tourName }}
                            </strong>

                        </div>


                        {{-- OPTION --}}

                        <div class="reservation-show-detail">

                            <span class="reservation-show-label">
                                {{ __('reservation.option') }}
                            </span>

                            <strong>
                                {{ $optionName }}
                            </strong>

                        </div>


                        {{-- DATE --}}

                        <div class="reservation-show-detail">

                            <span class="reservation-show-label">
                                {{ __('reservation.date') }}
                            </span>

                            <strong>
                                {{ $reservation->booking_date->format('d/m/Y') }}
                            </strong>

                        </div>


                        {{-- TIME --}}

                        <div class="reservation-show-detail">

                            <span class="reservation-show-label">
                                {{ __('reservation.time') }}
                            </span>

                            <strong>
                                {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}
                                —
                                {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}
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


                {{-- =================================================
                     BANK PAYMENT
                     Only while payment is pending
                ================================================== --}}

                @if($isPendingPayment)

                    <div class="reservation-show-card">

                        <div class="reservation-show-card-header">

                            <h2>
                                {{ __('reservation.bank_payment') }}
                            </h2>

                            <p class="reservation-show-card-description">
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


                            {{-- SWIFT / BIC --}}

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


                        <div class="reservation-show-bank-note">

                            {{ __('reservation.bank_payment_note') }}

                        </div>

                    </div>

                @endif

            </div>


            {{-- =====================================================
                 RIGHT COLUMN
                 STATUS + ACTIONS
            ====================================================== --}}

            <div class="reservation-show-column">


                {{-- =================================================
                     STATUS / PAYMENT
                ================================================== --}}

                <div class="reservation-show-card">

                    <div class="reservation-show-card-header">

                        <h2>
                            {{ __('reservation.reservation_status') }}
                        </h2>

                    </div>


                    {{-- STATUS --}}

                    <div class="reservation-show-status">

                        @if($isPendingPayment)

                            <span class="reservation-show-status-badge pending">
                                {{ __('reservation.pending_payment') }}
                            </span>

                        @elseif($isPaymentSubmitted)

                            <span class="reservation-show-status-badge submitted">
                                {{ __('reservation.payment_submitted') }}
                            </span>

                        @elseif($isConfirmed)

                            <span class="reservation-show-status-badge confirmed">
                                {{ __('reservation.confirmed') }}
                            </span>

                        @elseif($isCancelled)

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
                                €{{ $totalAmount }}
                            </strong>

                        </div>


                        {{-- DEPOSIT --}}

                        <div>

                            <span>
                                {{ __('reservation.deposit') }}
                                ({{ $reservation->deposit_percentage }}%)
                            </span>

                            <strong>
                                €{{ $depositAmount }}
                            </strong>

                        </div>


                        {{-- PAYMENT DEADLINE --}}

                        @if($reservation->payment_deadline_at && $isPendingPayment)

                            <div>

                                <span>
                                    {{ __('reservation.payment_deadline') }}
                                </span>

                                <strong>
                                    {{ $reservation->payment_deadline_at->format('d/m/Y H:i') }}
                                </strong>

                            </div>

                        @endif


                        {{-- PAYMENT SUBMITTED AT --}}

                        @if($isPaymentSubmitted && $reservation->payment_submitted_at)

                            <div>

                                <span>
                                    {{ __('reservation.payment_submitted_at') }}
                                </span>

                                <strong>
                                    {{ $reservation->payment_submitted_at->format('d/m/Y H:i') }}
                                </strong>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                         PENDING PAYMENT
                    ================================================== --}}

                    @if($isPendingPayment)


                        {{-- NEXT STEP --}}

                        <div class="reservation-show-notice">

                            <strong>
                                {{ __('reservation.next_step') }}
                            </strong>

                            <p>
                                {{ __('reservation.payment_instruction', [
                                    'amount' => '€' . $depositAmount
                                ]) }}
                            </p>

                            <p>
                                {{ __('reservation.proof_instruction') }}
                            </p>

                        </div>


                        {{-- PAYMENT PROOF --}}

                        <div class="reservation-show-proof">

                            <div class="reservation-show-proof-header">

                                <h3>
                                    {{ __('reservation.payment_proof_title') }}
                                </h3>

                                <p>
                                    {{ __('reservation.payment_proof_instruction') }}
                                </p>

                            </div>


                            <form
                                method="POST"
                                action="{{ route(
                                    'reservations.payment-proof',
                                    $reservation->public_token
                                ) }}"
                                enctype="multipart/form-data"
                                class="reservation-show-proof-form"
                            >

                                @csrf


                                <div class="reservation-show-proof-field">

                                    <label for="payment_proof">
                                        {{ __('reservation.payment_proof_file') }}
                                    </label>

                                    <input
                                        type="file"
                                        id="payment_proof"
                                        name="payment_proof"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        required
                                    >

                                    <small>
                                        {{ __('reservation.payment_proof_formats') }}
                                    </small>

                                </div>


                                @error('payment_proof')

                                    <p class="reservation-show-form-error">
                                        {{ $message }}
                                    </p>

                                @enderror


                                <button
                                    type="submit"
                                    class="reservation-show-primary-button"
                                >
                                    {{ __('reservation.payment_proof_submit') }}
                                </button>

                            </form>

                        </div>


                        {{-- CANCEL RESERVATION --}}

                        <div class="reservation-show-cancel">

                            <h3>
                                {{ __('reservation.cancel_title') }}
                            </h3>

                            <p>
                                {{ __('reservation.cancel_instruction') }}
                            </p>


                            <form
                                method="POST"
                                action="{{ route(
                                    'reservations.cancel',
                                    $reservation->public_token
                                ) }}"
                                onsubmit="return confirm(
                                    @js(__('reservation.cancel_confirmation'))
                                )"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="reservation-show-cancel-button"
                                >
                                    {{ __('reservation.cancel_button') }}
                                </button>

                            </form>

                        </div>


                    {{-- =================================================
                         PAYMENT SUBMITTED
                    ================================================== --}}

                    @elseif($isPaymentSubmitted)

                        <div class="reservation-show-success-notice">

                            <strong>
                                {{ __('reservation.payment_submitted_title') }}
                            </strong>

                            <p>
                                {{ __('reservation.payment_submitted_message') }}
                            </p>

                        </div>


                    {{-- =================================================
                         CONFIRMED
                    ================================================== --}}

                    @elseif($isConfirmed)

                        <div class="reservation-show-success-notice">

                            <strong>
                                {{ __('reservation.confirmed_title') }}
                            </strong>

                            <p>
                                {{ __('reservation.confirmed_message') }}
                            </p>

                        </div>


                    {{-- =================================================
                         CANCELLED
                    ================================================== --}}

                    @elseif($isCancelled)

                        <div class="reservation-show-cancelled-notice">

                            <strong>
                                {{ __('reservation.cancelled_title') }}
                            </strong>

                            <p>
                                {{ __('reservation.cancelled_message') }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>

    </div>

</section>

@endsection