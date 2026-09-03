@extends('layouts.admin')

@section('content')

<div class="admin-page admin-tours-page">

    <div class="admin-page-header">

        <div>
            <h1>Passeios</h1>

            <p>
                Gerir os passeios do Tours N Fish.
            </p>
        </div>

        <a
            href="{{ route('admin.tours.create') }}"
            class="admin-tours-add-button"
        >
            + Novo Passeio
        </a>

    </div>

    @if(session('success'))

        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>

    @endif

    <div class="admin-tours-table-card">

        <div class="admin-tours-table-wrap">

            <table class="admin-tours-table">

                <thead>
                    <tr>
                        <th>Capa</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Duração</th>
                        <th class="is-center">Disponível</th>
                        <th class="is-center">Home</th>
                        <th class="is-right">Ações</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($tours as $tour)

                    @php
                        $isFirst = $loop->first;
                        $isLast = $loop->last;

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

                    <tr>

                        <td>
                            <img
                                src="{{ asset('storage/' . $tour->cover_image) }}"
                                alt="{{ $translation?->name }}"
                                class="admin-tours-thumbnail"
                            >
                        </td>

                        <td>
                            <div class="admin-tours-name">
                                {{ $translation?->name ?? 'Sem nome' }}
                            </div>
                        </td>

                        <td>
                            @if($option)
                                € {{ number_format($option->price, 2, ',', '.') }}
                            @else
                                —
                            @endif
                        </td>

                        <td>
                            {{ $formattedDuration }}
                        </td>

                        <td class="is-center">

                            @if($tour->available)

                                <span class="admin-tours-status admin-tours-status-available">
                                    Disponível
                                </span>

                            @else

                                <span class="admin-tours-status admin-tours-status-unavailable">
                                    Indisponível
                                </span>

                            @endif

                        </td>

                        <td class="is-center">

                            @if($tour->featured_home)

                                <span class="admin-tours-home-active" aria-label="Em destaque na Home">
                                    ⭐
                                </span>

                            @else

                                <span class="admin-tours-home-inactive" aria-label="Não está em destaque na Home">
                                    ★
                                </span>

                            @endif

                        </td>

                        <td class="is-right">

                            <div class="admin-tours-actions">

                                @unless($isFirst)

                                    <form
                                        action="{{ route('admin.tours.move', $tour) }}"
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
                                            class="admin-tours-order-button"
                                            aria-label="Mover para cima"
                                        >
                                            ↑
                                        </button>

                                    </form>

                                @endunless

                                @unless($isLast)

                                    <form
                                        action="{{ route('admin.tours.move', $tour) }}"
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
                                            class="admin-tours-order-button"
                                            aria-label="Mover para baixo"
                                        >
                                            ↓
                                        </button>

                                    </form>

                                @endunless

                                <a
                                    href="{{ route('admin.tours.edit', $tour) }}"
                                    class="admin-reservation-action"
                                >
                                    Editar
                                </a>

                                <form
                                    action="{{ route('admin.tours.destroy', $tour) }}"
                                    method="POST"
                                    onsubmit="return confirm('Tem a certeza que pretende eliminar este passeio?');"
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
                            colspan="7"
                            class="admin-tours-empty"
                        >
                            Ainda não existem passeios.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection