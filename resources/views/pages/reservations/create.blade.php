@extends('layouts.app')

@section('title', 'Reservar ' . $tour->translation()->name)

@section('content')

<section class="reservation-page">

    <div class="container-custom">

        <div class="section-heading">

            <span class="section-badge">
                Reserva
            </span>

            <h1 class="section-title">
                {{ $option->translation()->name }}
            </h1>

            <p>
                {{ $tour->translation()->name }}
            </p>

        </div>


        <div class="reservation-summary">

            <h2>
                Dados do passeio
            </h2>

            <p>
                <strong>Opção:</strong>
                {{ $option->translation()->name }}
            </p>

            <p>
                <strong>Horário:</strong>

                {{ substr($schedule->start_time, 0, 5) }}

                —

                {{ substr($schedule->end_time, 0, 5) }}
            </p>

            <p>
                <strong>Duração:</strong>
                {{ $option->duration_minutes }} minutos
            </p>

            <p>
                <strong>Capacidade máxima:</strong>
                {{ $tour->max_capacity }} pessoas
            </p>

            <p>
                <strong>Preço do passeio:</strong>
                €{{ number_format($option->price, 2, ',', '.') }}
            </p>

            <p>
                <strong>Sinal de 10%:</strong>
                €{{ number_format($option->price * 0.10, 2, ',', '.') }}
            </p>

        </div>


        <form
            method="POST"
            action="{{ route('reservations.store') }}"
            class="reservation-form">

            @csrf

            {{-- Identificação da reserva --}}

            <input
                type="hidden"
                name="tour_id"
                value="{{ $tour->id }}">

            <input
                type="hidden"
                name="tour_option_id"
                value="{{ $option->id }}">

            <input
                type="hidden"
                name="tour_option_schedule_id"
                value="{{ $schedule->id }}">


            {{-- Data --}}

            <div>

                <label for="booking_date">
                    Data do passeio
                </label>

                <input
                    type="date"
                    id="booking_date"
                    name="booking_date"
                    value="{{ old('booking_date') }}"
                    required>

                @error('booking_date')
                    <p>{{ $message }}</p>
                @enderror

            </div>


            {{-- Número de pessoas --}}

            <div>

                <label for="participants">
                    Número de pessoas
                </label>

                <input
                    type="number"
                    id="participants"
                    name="participants"
                    min="1"
                    max="{{ $tour->max_capacity }}"
                    value="{{ old('participants', 1) }}"
                    required>

                @error('participants')
                    <p>{{ $message }}</p>
                @enderror

            </div>


            {{-- Nome --}}

            <div>

                <label for="customer_name">
                    Nome
                </label>

                <input
                    type="text"
                    id="customer_name"
                    name="customer_name"
                    value="{{ old('customer_name') }}"
                    required>

                @error('customer_name')
                    <p>{{ $message }}</p>
                @enderror

            </div>


            {{-- Email --}}

            <div>

                <label for="customer_email">
                    Email
                </label>

                <input
                    type="email"
                    id="customer_email"
                    name="customer_email"
                    value="{{ old('customer_email') }}"
                    required>

                @error('customer_email')
                    <p>{{ $message }}</p>
                @enderror

            </div>


            {{-- Telefone --}}

            <div>

                <label for="customer_phone">
                    Telefone
                </label>

                <input
                    type="text"
                    id="customer_phone"
                    name="customer_phone"
                    value="{{ old('customer_phone') }}"
                    required>

                @error('customer_phone')
                    <p>{{ $message }}</p>
                @enderror

            </div>


            {{-- Mensagem --}}

            <div>

                <label for="customer_message">
                    Observações
                </label>

                <textarea
                    id="customer_message"
                    name="customer_message"
                    rows="5">{{ old('customer_message') }}</textarea>

                @error('customer_message')
                    <p>{{ $message }}</p>
                @enderror

            </div>


            <button
                type="submit"
                class="btn btn-primary">

                Enviar pedido de reserva

            </button>

        </form>

    </div>

</section>

@endsection