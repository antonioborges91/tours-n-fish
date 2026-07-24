@extends('layouts.admin')

@section('content')

<div class="flex items-center justify-between mb-8">

    <div>

        <h1 class="text-3xl font-bold">
            Passeios
        </h1>

        <p class="mt-1 text-gray-500">
            Gerir os passeios do Tours N Fish.
        </p>

    </div>

    <a
        href="{{ route('admin.tours.create') }}"
        class="admin-btn-primary">

        + Novo Passeio

    </a>

</div>

@if(session('success'))

    <div class="mb-6 rounded-lg border border-green-300 bg-green-50 p-4 text-green-700">

        {{ session('success') }}

    </div>

@endif

<div class="overflow-hidden rounded-lg bg-white shadow">

    <table class="w-full">

        <thead class="bg-gray-100">

            <tr>

                <th class="p-4 text-left">
                    Capa
                </th>

                <th class="p-4 text-left">
                    Nome
                </th>

                <th class="p-4 text-left">
                    Preço
                </th>

                <th class="p-4 text-left">
                    Duração
                </th>

                <th class="p-4 text-center">
                    Disponível
                </th>

                <th class="p-4 text-center">
                    Home
                </th>

                <th class="p-4 text-right">
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($tours as $tour)

            @php

                $translation = $tour->translations
                    ->firstWhere('locale', 'pt');

                $option = $tour->options
                    ->sortBy('display_order')
                    ->first();

                $formattedDuration = '—';

                if ($option) {

                    $minutes = (int) $option->duration_minutes;

                    if ($minutes < 60) {

                        $formattedDuration = $minutes . ' min';

                    } else {

                        $hours = intdiv($minutes, 60);
                        $remainingMinutes = $minutes % 60;

                        $formattedDuration = $hours . ' h';

                        if ($remainingMinutes > 0) {
                            $formattedDuration .= ' ' . $remainingMinutes . ' min';
                        }

                    }

                }

            @endphp

            <tr class="border-t">

                <td class="p-4">

                    <img
                        src="{{ asset('storage/' . $tour->cover_image) }}"
                        alt="{{ $translation?->name }}"
                        class="h-24 w-24 rounded-lg object-cover">

                </td>

                <td class="p-4 font-medium">

                    <div class="max-w-xs truncate">

                        {{ $translation?->name ?? 'Sem nome' }}

                    </div>

                </td>

                <td class="p-4">

                    @if($option)

                        € {{ number_format($option->price, 2, ',', '.') }}

                    @else

                        —

                    @endif

                </td>

                <td class="p-4">

                    {{ $formattedDuration }}

                </td>

                <td class="p-4 text-center">

                    @if($tour->available)

                        <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">

                            Disponível

                        </span>

                    @else

                        <span class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">

                            Indisponível

                        </span>

                    @endif

                </td>

                <td class="p-4 text-center text-xl">

                    @if($tour->featured_home)

                        ⭐

                    @else

                        <span class="text-gray-400">
                            ★
                        </span>

                    @endif

                </td>

                <td class="p-4">

                    <div class="flex justify-end gap-3">

                        <a
                            href="{{ route('admin.tours.edit', $tour) }}"
                            class="admin-btn-secondary">

                            Editar

                        </a>

                        <form
                            action="{{ route('admin.tours.destroy', $tour) }}"
                            method="POST"
                            onsubmit="return confirm('Tem a certeza que pretende eliminar este passeio?');">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="admin-btn-danger">

                                Eliminar

                            </button>

                        </form>

                    </div>

                </td>

            </tr>

        @empty

            <tr>

                <td
                    colspan="7"
                    class="py-12 text-center text-gray-500">

                    Ainda não existem passeios.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection