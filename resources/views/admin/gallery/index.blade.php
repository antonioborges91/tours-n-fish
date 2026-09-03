@extends('layouts.admin')

@section('content')

<div class="admin-page admin-gallery-page">

    <div class="admin-page-header">

        <div>
            <h1>Galeria</h1>

            <p>
                Gerir as fotografias da galeria.
            </p>
        </div>

        <a
            href="{{ route('admin.gallery.create') }}"
            class="admin-gallery-add-button"
        >
            + Adicionar Fotografia
        </a>

    </div>

    @if(session('success'))

        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="admin-gallery-table-card">

        <div class="admin-gallery-table-wrap">

            <table class="admin-gallery-table">

                <thead>

                    <tr>
                        <th>Fotografia</th>
                        <th class="is-center">Estado</th>
                        <th class="is-center">Ordem</th>
                        <th class="is-right">Ações</th>
                    </tr>

                </thead>

                <tbody>

                @forelse($photos as $photo)

                    @php
                        $isFirst = $loop->first;
                        $isLast = $loop->last;
                    @endphp

                    <tr>

                        <td>

                            <img
                                src="{{ asset('storage/' . $photo->image) }}"
                                alt="Fotografia"
                                class="admin-gallery-thumbnail"
                            >

                        </td>

                        <td class="is-center">

                            @if($photo->is_active)

                                <span class="admin-gallery-status admin-gallery-status-active">
                                    Ativa
                                </span>

                            @else

                                <span class="admin-gallery-status admin-gallery-status-inactive">
                                    Inativa
                                </span>

                            @endif

                        </td>

                        <td class="is-center">

                            <span class="admin-gallery-order">
                                {{ $photo->sort_order }}
                            </span>

                        </td>

                        <td class="is-right">

                            <div class="admin-gallery-actions">

                                @unless($isFirst)

                                    <form
                                        action="{{ route('admin.gallery.move', $photo) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="direction"
                                            value="up"
                                        >

                                        <button
                                            type="submit"
                                            class="admin-gallery-order-button"
                                            aria-label="Mover para cima"
                                        >
                                            ↑
                                        </button>

                                    </form>

                                @endunless

                                @unless($isLast)

                                    <form
                                        action="{{ route('admin.gallery.move', $photo) }}"
                                        method="POST"
                                    >

                                        @csrf

                                        <input
                                            type="hidden"
                                            name="direction"
                                            value="down"
                                        >

                                        <button
                                            type="submit"
                                            class="admin-gallery-order-button"
                                            aria-label="Mover para baixo"
                                        >
                                            ↓
                                        </button>

                                    </form>

                                @endunless

                                <a
                                    href="{{ route('admin.gallery.edit', $photo) }}"
                                    class="admin-reservation-action"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('admin.gallery.destroy', $photo) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem a certeza que pretende eliminar esta fotografia?');"
                                >

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="admin-reservation-action admin-reservation-action-delete"
                                    >
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
                            class="admin-gallery-empty"
                        >
                            Ainda não existem fotografias.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection