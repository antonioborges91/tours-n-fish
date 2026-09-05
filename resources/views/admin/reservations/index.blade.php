@extends('layouts.admin')

@section('content')

<div class="admin-page admin-reservations-page">

    <div class="admin-page-header">
        <div>
            <h1>Reservas</h1>
            <p>Gerir as reservas dos passeios.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-reservations-filters-card">

        <form
            method="GET"
            action="{{ route('admin.reservations.index') }}"
            class="admin-reservations-filters"
        >

            <div class="admin-reservations-filter-field admin-reservations-filter-search">

                <label for="reservation-search">
                    Pesquisa
                </label>

                <input
                    id="reservation-search"
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Nome, email, telefone ou nº da reserva"
                >

            </div>

            <div class="admin-reservations-filter-field">

                <label for="reservation-date-from">
                    Data desde
                </label>

                <input
                    id="reservation-date-from"
                    type="date"
                    name="date_from"
                    value="{{ request('date_from') }}"
                >

            </div>

            <div class="admin-reservations-filter-field">

                <label for="reservation-date-to">
                    Data até
                </label>

                <input
                    id="reservation-date-to"
                    type="date"
                    name="date_to"
                    value="{{ request('date_to') }}"
                >

            </div>

            <div class="admin-reservations-filter-field">

                <label for="reservation-status">
                    Estado
                </label>

                <select
                    id="reservation-status"
                    name="status"
                >
                    <option value="">Todos os estados</option>

                    <option
                        value="pending_payment"
                        @selected(request('status') === 'pending_payment')
                    >
                        A aguardar pagamento
                    </option>

                    <option
                        value="payment_submitted"
                        @selected(request('status') === 'payment_submitted')
                    >
                        Comprovativo enviado
                    </option>

                    <option
                        value="confirmed"
                        @selected(request('status') === 'confirmed')
                    >
                        Confirmada
                    </option>

                    <option
                        value="rejected"
                        @selected(request('status') === 'rejected')
                    >
                        Rejeitada
                    </option>

                    <option
                        value="cancelled"
                        @selected(request('status') === 'cancelled')
                    >
                        Cancelada
                    </option>

                    <option
                        value="expired"
                        @selected(request('status') === 'expired')
                    >
                        Expirada
                    </option>
                </select>

            </div>

            <div class="admin-reservations-filter-actions">

                <button
                    type="submit"
                    class="admin-reservations-filter-submit"
                >
                    Filtrar
                </button>

                @if(request()->hasAny([
                    'search',
                    'date_from',
                    'date_to',
                    'status',
                ]))
                    <a
                        href="{{ route('admin.reservations.index') }}"
                        class="admin-reservations-filter-reset"
                    >
                        Limpar
                    </a>
                @endif

            </div>

        </form>

        @if(request()->hasAny([
            'search',
            'date_from',
            'date_to',
            'status',
        ]))

            <div class="admin-reservations-active-filters">

                <span class="admin-reservations-active-label">
                    Filtros ativos:
                </span>

                @if(request('search'))
                    <a
                        href="{{ request()->fullUrlWithQuery(['search' => null, 'page' => null]) }}"
                        class="admin-reservation-filter-tag"
                    >
                        Pesquisa: {{ request('search') }}
                        <span aria-hidden="true">×</span>
                    </a>
                @endif

                @if(request('date_from'))
                    <a
                        href="{{ request()->fullUrlWithQuery(['date_from' => null, 'page' => null]) }}"
                        class="admin-reservation-filter-tag"
                    >
                        Desde: {{ \Carbon\Carbon::parse(request('date_from'))->format('d/m/Y') }}
                        <span aria-hidden="true">×</span>
                    </a>
                @endif

                @if(request('date_to'))
                    <a
                        href="{{ request()->fullUrlWithQuery(['date_to' => null, 'page' => null]) }}"
                        class="admin-reservation-filter-tag"
                    >
                        Até: {{ \Carbon\Carbon::parse(request('date_to'))->format('d/m/Y') }}
                        <span aria-hidden="true">×</span>
                    </a>
                @endif

                @if(request('status'))

                    @php
                        $activeStatusLabels = [
                            'pending_payment' => 'A aguardar pagamento',
                            'payment_submitted' => 'Comprovativo enviado',
                            'confirmed' => 'Confirmada',
                            'rejected' => 'Rejeitada',
                            'cancelled' => 'Cancelada',
                            'expired' => 'Expirada',
                        ];
                    @endphp

                    <a
                        href="{{ request()->fullUrlWithQuery(['status' => null, 'page' => null]) }}"
                        class="admin-reservation-filter-tag"
                    >
                        Estado:
                        {{ $activeStatusLabels[request('status')] ?? request('status') }}
                        <span aria-hidden="true">×</span>
                    </a>

                @endif

            </div>

        @endif

    </div>


    <div class="admin-reservations-table-card">

        <div class="admin-reservations-table-wrap">

            <table class="admin-reservations-table">

                <thead>
                    <tr>
                        <th>Reserva</th>
                        <th>Data</th>
                        <th>Passeio</th>
                        <th>Horário</th>
                        <th>Cliente</th>
                        <th class="is-center">Pessoas</th>
                        <th class="is-right">Valor</th>
                        <th class="is-center">Estado</th>
                        <th class="is-right">Ações</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($reservations as $reservation)

                    @php
                        $tourTranslation = $reservation->tour?->translation();
                        $optionTranslation = $reservation->option?->translation();

                        $statusLabels = [
                            'pending_payment' => 'A aguardar pagamento',
                            'payment_submitted' => 'Comprovativo enviado',
                            'confirmed' => 'Confirmada',
                            'rejected' => 'Rejeitada',
                            'cancelled' => 'Cancelada',
                            'expired' => 'Expirada',
                        ];

                        $statusLabel = $statusLabels[$reservation->status]
                            ?? $reservation->status;
                    @endphp

                    <tr class="admin-reservation-row">

                        <td data-label="Reserva">
                            <strong class="admin-reservation-number">
                                #{{ $reservation->reservation_number }}
                            </strong>
                        </td>

                        <td data-label="Data">
                            <strong>
                                {{ $reservation->booking_date?->format('d/m/Y') ?? '—' }}
                            </strong>
                        </td>

                        <td data-label="Passeio">
                            <div class="admin-table-primary">
                                {{ $tourTranslation?->name ?? 'Passeio' }}
                            </div>

                            @if($optionTranslation?->name)
                                <div class="admin-table-secondary">
                                    {{ $optionTranslation->name }}
                                </div>
                            @endif
                        </td>

                        <td data-label="Horário">
                            {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}
                        </td>

                        <td data-label="Cliente">
                            <div class="admin-table-primary">
                                {{ $reservation->customer_name }}
                            </div>

                            <div class="admin-table-secondary">
                                {{ $reservation->customer_email }}
                            </div>
                        </td>

                        <td
                            data-label="Pessoas"
                            class="is-center"
                        >
                            {{ $reservation->participants }}
                        </td>

                        <td
                            data-label="Valor"
                            class="is-right"
                        >
                            <strong>
                                € {{ number_format($reservation->total_amount, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td
                            data-label="Estado"
                            class="is-center"
                        >
                            <span class="admin-status admin-status-{{ $reservation->status }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td
                            data-label="Ações"
                            class="is-right admin-reservation-mobile-action"
                        >
                            <a
                                href="{{ route('admin.reservations.show', $reservation) }}"
                                class="admin-reservation-action"
                            >
                                Ver
                            </a>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="9"
                            class="admin-reservations-empty"
                        >
                            @if(request()->hasAny([
                                'search',
                                'date_from',
                                'date_to',
                                'status',
                            ]))
                                Não foram encontradas reservas com os filtros selecionados.
                            @else
                                Ainda não existem reservas.
                            @endif
                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        @if($reservations->hasPages())

            <div class="admin-reservations-pagination">
                {{ $reservations->links() }}
            </div>

        @endif

    </div>

</div>

@endsection