@extends('layouts.admin')

@section('content')

<div class="flex items-end justify-between">

    <div>

        <h1 class="text-3xl font-bold">
            Reservas
        </h1>

        <p class="mt-1 text-gray-500">
            Gerir as reservas dos passeios.
        </p>

    </div>

</div>

@if(session('success'))

    <div class="mb-6 mt-6 rounded-lg border border-green-300 bg-green-50 p-4 text-green-700">

        {{ session('success') }}

    </div>

@endif

<div class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Data
                </th>

                <th class="p-4 text-left">
                    Passeio
                </th>

                <th class="p-4 text-left">
                    Horário
                </th>

                <th class="p-4 text-left">
                    Cliente
                </th>

                <th class="p-4 text-center">
                    Pessoas
                </th>

                <th class="p-4 text-right">
                    Valor
                </th>

                <th class="p-4 text-center">
                    Estado
                </th>

                <th class="p-4 text-right">
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($reservations as $reservation)

            @php
                $tourTranslation = $reservation->tour?->translation();
                $optionTranslation = $reservation->option?->translation();
            @endphp

            <tr class="border-t">

                <td class="p-4">

                    <div class="font-medium text-gray-900">

                        {{ $reservation->booking_date->format('d/m/Y') }}

                    </div>

                </td>

                <td class="p-4">

                    <div class="font-medium text-gray-900">

                        {{ $tourTranslation?->name ?? 'Passeio' }}

                    </div>

                    @if($optionTranslation?->name)

                        <div class="text-sm text-gray-500">

                            {{ $optionTranslation->name }}

                        </div>

                    @endif

                </td>

                <td class="p-4">

                    {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}

                    -

                    {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}

                </td>

                <td class="p-4">

                    <div class="font-medium text-gray-900">

                        {{ $reservation->customer_name }}

                    </div>

                    <div class="text-sm text-gray-500">

                        {{ $reservation->customer_email }}

                    </div>

                </td>

                <td class="p-4 text-center">

                    {{ $reservation->participants }}

                </td>

                <td class="p-4 text-right">

                    € {{ number_format($reservation->total_amount, 2, ',', '.') }}

                </td>

                <td class="p-4 text-center">

                    @switch($reservation->status)

                        @case('pending_payment')

                            <span class="rounded-full bg-yellow-100 px-3 py-1 text-sm text-yellow-700">

                                A aguardar pagamento

                            </span>

                            @break

                        @case('payment_submitted')

                            <span class="rounded-full bg-blue-100 px-3 py-1 text-sm text-blue-700">

                                Comprovativo enviado

                            </span>

                            @break

                        @case('confirmed')

                            <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">

                                Confirmada

                            </span>

                            @break

                        @case('rejected')

                            <span class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">

                                Rejeitada

                            </span>

                            @break

                        @case('cancelled')

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">

                                Cancelada

                            </span>

                            @break

                        @default

                            <span class="rounded-full bg-gray-100 px-3 py-1 text-sm text-gray-700">

                                {{ $reservation->status }}

                            </span>

                    @endswitch

                </td>

                <td class="p-4">

                    <div class="flex items-center justify-end gap-2">

                        <a
                            href="{{ route('admin.reservations.show', $reservation) }}"
                            class="admin-btn-secondary">

                            Ver

                        </a>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="8"
                    class="py-12 text-center text-gray-500">

                    Ainda não existem reservas.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection