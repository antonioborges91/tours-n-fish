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

            @endphp

            <tr class="border-t">

                <td class="p-4">

                    <img
                        src="{{ asset('storage/' . $tour->cover_image) }}"
                        class="h-24 w-24 rounded-lg object-cover">

                </td>

                <td class="p-4 font-medium">

                    <div class="max-w-xs truncate">

                        {{ $translation?->name ?? 'Sem nome' }}

                    </div>

                </td>

                <td class="p-4">

                    € {{ number_format($tour->price, 2, ',', '.') }}

                </td>

                <td class="p-4">

                    {{ $tour->duration }}

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

                        <span class="text-gray-400 text-xl">
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

                        <button
                            class="admin-btn-danger">

                            Eliminar

                        </button>

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