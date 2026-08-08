@extends('layouts.admin')

@section('content')

<div class="flex items-end justify-between">

    <div>

        <h1 class="text-3xl font-bold">
            Galeria
        </h1>

        <p class="mt-1 text-gray-500">
            Gerir as fotografias da galeria.
        </p>

    </div>

    <a
        href="{{ route('admin.gallery.create') }}"
        class="admin-btn-primary">

        + Adicionar Fotografia

    </a>

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
                    Fotografia
                </th>

                <th class="p-4 text-center">
                    Estado
                </th>

                <th class="p-4 text-center">
                    Ordem
                </th>

                <th class="p-4 text-right">
                    Ações
                </th>

            </tr>

        </thead>

        <tbody>

        @forelse($photos as $photo)

            @php
                $isFirst = $loop->first;
                $isLast = $loop->last;
            @endphp

            <tr class="border-t">

                <td class="p-4">

                    <img
                        src="{{ asset('storage/' . $photo->image) }}"
                        alt="Fotografia"
                        class="h-24 w-24 rounded-lg object-cover">

                </td>

                <td class="p-4 text-center">

                    @if($photo->is_active)

                        <span class="rounded-full bg-green-100 px-3 py-1 text-sm text-green-700">

                            Ativa

                        </span>

                    @else

                        <span class="rounded-full bg-red-100 px-3 py-1 text-sm text-red-700">

                            Inativa

                        </span>

                    @endif

                </td>

                <td class="p-4 text-center">

                    {{ $photo->sort_order }}

                </td>

                <td class="p-4">

                    <div class="flex items-center justify-end gap-2">

                        @unless($isFirst)

                            <form
                                action="{{ route('admin.gallery.move', $photo) }}"
                                method="POST">

                                @csrf

                                <input
                                    type="hidden"
                                    name="direction"
                                    value="up">

                                <button
                                    type="submit"
                                    class="admin-btn-secondary">

                                    ↑

                                </button>

                            </form>

                        @endunless

                        @unless($isLast)

                            <form
                                action="{{ route('admin.gallery.move', $photo) }}"
                                method="POST">

                                @csrf

                                <input
                                    type="hidden"
                                    name="direction"
                                    value="down">

                                <button
                                    type="submit"
                                    class="admin-btn-secondary">

                                    ↓

                                </button>

                            </form>

                        @endunless

                        <a
                            href="{{ route('admin.gallery.edit', $photo) }}"
                            class="admin-btn-secondary">

                            Editar

                        </a>

                        <form
                            action="{{ route('admin.gallery.destroy', $photo) }}"
                            method="POST"
                            onsubmit="return confirm('Tem a certeza que pretende eliminar esta fotografia?');">

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
                    colspan="4"
                    class="py-12 text-center text-gray-500">

                    Ainda não existem fotografias.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection