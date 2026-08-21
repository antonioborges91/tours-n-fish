@extends('layouts.app')

@section('title', 'Confirmar reserva - ' . $tour->translation()->name)

@section('content')

@php
    $translation = $tour->translation();
    $optionTranslation = $option->translation();

    /*
    |--------------------------------------------------------------------------
    | Dados selecionados no passo anterior
    |--------------------------------------------------------------------------
    */

    $bookingDate = old(
        'booking_date',
        request('booking_date')
    );

    $participants = old(
        'participants',
        request('people', 1)
    );

    $formattedDate = null;

    if ($bookingDate) {
        $formattedDate = \Carbon\Carbon::parse($bookingDate)
            ->locale(app()->getLocale())
            ->translatedFormat('d \d\e F \d\e Y');
    }

    /*
    |--------------------------------------------------------------------------
    | Preços
    |--------------------------------------------------------------------------
    */

    $formattedPrice = number_format(
        $option->price,
        2,
        ',',
        '.'
    );

    $depositAmount = number_format(
        $option->price * 0.10,
        2,
        ',',
        '.'
    );

    /*
    |--------------------------------------------------------------------------
    | Duração
    |--------------------------------------------------------------------------
    */

    $durationHours = intdiv(
        $option->duration_minutes,
        60
    );

    $durationMinutes = $option->duration_minutes % 60;

    if ($durationMinutes > 0) {
        $formattedDuration =
            $durationHours . ' h ' .
            $durationMinutes . ' min';
    } else {
        $formattedDuration =
            $durationHours . ' h';
    }
@endphp


<section class="reservation-page">

    <div class="container-custom">

        {{-- =========================================================
             CABEÇALHO
        ========================================================== --}}

        <div class="section-heading reservation-heading">

            <span class="section-badge">
                Reserva
            </span>

            <h1 class="section-title">
                Confirmar reserva
            </h1>

            <p>
                Verifique os dados do passeio e preencha os seus dados.
            </p>

        </div>


        {{-- =========================================================
             CONTEÚDO
        ========================================================== --}}

        <div class="reservation-layout">


            {{-- =====================================================
                 RESUMO DA RESERVA
            ====================================================== --}}

            <div class="reservation-card">

                {{-- =================================================
                     IDENTIDADE DO PASSEIO
                ================================================== --}}

                <div class="reservation-tour">

                    @if ($tour->cover_image)

                        <div class="reservation-tour-image">

                            <img
                                src="{{ asset('storage/' . $tour->cover_image) }}"
                                alt="{{ $translation?->name }}"
                            >

                        </div>

                    @endif


                    <div class="reservation-tour-info">

                        <span class="reservation-tour-label">
                            Passeio
                        </span>

                        <h2>
                            {{ $translation?->name }}
                        </h2>

                    </div>

                </div>


                {{-- =================================================
                     DETALHES
                ================================================== --}}

                <div class="reservation-card-header">

                    <h2>
                        Resumo da reserva
                    </h2>

                </div>


                <div class="reservation-details">


                    {{-- Opção --}}

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Opção
                        </span>

                        <strong>
                            {{ $optionTranslation?->name }}
                        </strong>

                    </div>


                    {{-- Data --}}

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Data
                        </span>

                        <strong>

                            @if ($formattedDate)
                                {{ $formattedDate }}
                            @else
                                —
                            @endif

                        </strong>

                    </div>


                    {{-- Horário --}}

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Horário
                        </span>

                        <strong>

                            {{ substr($schedule->start_time, 0, 5) }}

                            —

                            {{ substr($schedule->end_time, 0, 5) }}

                        </strong>

                    </div>


                    {{-- Duração --}}

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Duração
                        </span>

                        <strong>
                            {{ $formattedDuration }}
                        </strong>

                    </div>


                    {{-- Pessoas --}}

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Número de pessoas
                        </span>

                        <strong>
                            {{ $participants }}
                        </strong>

                    </div>

                </div>


                {{-- =================================================
                     PREÇOS
                ================================================== --}}

                <div class="reservation-price-box">

                    <div>

                        <span>
                            Total do passeio
                        </span>

                        <strong>
                            €{{ $formattedPrice }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Sinal de 10%
                        </span>

                        <strong>
                            €{{ $depositAmount }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                 DADOS DO CLIENTE
            ====================================================== --}}

            <div class="reservation-card">

                <div class="reservation-card-header">

                    <h2>
                        Os seus dados
                    </h2>

                    <p>
                        Preencha os seus dados para solicitar a reserva.
                    </p>

                </div>


                <form
                    method="POST"
                    action="{{ route('reservations.store') }}"
                    class="reservation-form"
                >

                    @csrf


                    {{-- =================================================
                         IDENTIFICAÇÃO DA RESERVA
                    ================================================== --}}

                    <input
                        type="hidden"
                        name="tour_option_id"
                        value="{{ $option->id }}"
                    >

                    <input
                        type="hidden"
                        name="tour_option_schedule_id"
                        value="{{ $schedule->id }}"
                    >

                    <input
                        type="hidden"
                        name="booking_date"
                        value="{{ $bookingDate }}"
                    >

                    <input
                        type="hidden"
                        name="participants"
                        value="{{ $participants }}"
                    >


                    {{-- =================================================
                         NOME
                    ================================================== --}}

                    <div class="reservation-field">

                        <label for="customer_name">
                            Nome
                        </label>

                        <input
                            type="text"
                            id="customer_name"
                            name="customer_name"
                            value="{{ old('customer_name') }}"
                            autocomplete="name"
                            required
                        >

                        @error('customer_name')

                            <p class="reservation-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         EMAIL
                    ================================================== --}}

                    <div class="reservation-field">

                        <label for="customer_email">
                            Email
                        </label>

                        <input
                            type="email"
                            id="customer_email"
                            name="customer_email"
                            value="{{ old('customer_email') }}"
                            autocomplete="email"
                            required
                        >

                        @error('customer_email')

                            <p class="reservation-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         TELEFONE
                    ================================================== --}}

                    <div class="reservation-field">

                        <label for="customer_phone">
                            Telefone
                        </label>

                        <input
                            type="tel"
                            id="customer_phone"
                            name="customer_phone"
                            value="{{ old('customer_phone') }}"
                            autocomplete="tel"
                            required
                        >

                        @error('customer_phone')

                            <p class="reservation-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         OBSERVAÇÕES
                    ================================================== --}}

                    <div class="reservation-field">

                        <label for="customer_message">
                            Observações
                        </label>

                        <textarea
                            id="customer_message"
                            name="customer_message"
                            rows="5"
                            placeholder="Alguma informação que considere importante?"
                        >{{ old('customer_message') }}</textarea>

                        @error('customer_message')

                            <p class="reservation-error">
                                {{ $message }}
                            </p>

                        @enderror

                    </div>


                    {{-- =================================================
                         AVISO
                    ================================================== --}}

                    <div class="reservation-notice">

                        <strong>
                            Antes de enviar
                        </strong>

                        <p>
                            O envio deste formulário não confirma
                            imediatamente a reserva. O pedido ficará
                            sujeito à disponibilidade e à confirmação
                            do pagamento do sinal.
                        </p>

                    </div>


                    {{-- =================================================
                         AÇÕES
                    ================================================== --}}

                    <div class="reservation-actions">

                        <a
                            href="{{ route('tours.show', $tour) }}#tour-reservation"
                            class="btn btn-secondary reservation-secondary-button"
                        >
                            ← Voltar
                        </a>


                        <button
                            type="submit"
                            class="btn btn-primary reservation-submit-button"
                        >
                            Enviar pedido de reserva
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</section>

@endsection