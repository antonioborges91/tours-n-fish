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

                    <tr>

                        <td>
                            <strong class="admin-reservation-number">
                                #{{ $reservation->reservation_number }}
                            </strong>
                        </td>

                        <td>
                            <strong>
                                {{ $reservation->booking_date?->format('d/m/Y') ?? '—' }}
                            </strong>
                        </td>

                        <td>
                            <div class="admin-table-primary">
                                {{ $tourTranslation?->name ?? 'Passeio' }}
                            </div>

                            @if($optionTranslation?->name)
                                <div class="admin-table-secondary">
                                    {{ $optionTranslation->name }}
                                </div>
                            @endif
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}
                        </td>

                        <td>
                            <div class="admin-table-primary">
                                {{ $reservation->customer_name }}
                            </div>

                            <div class="admin-table-secondary">
                                {{ $reservation->customer_email }}
                            </div>
                        </td>

                        <td class="is-center">
                            {{ $reservation->participants }}
                        </td>

                        <td class="is-right">
                            <strong>
                                € {{ number_format($reservation->total_amount, 2, ',', '.') }}
                            </strong>
                        </td>

                        <td class="is-center">
                            <span class="admin-status admin-status-{{ $reservation->status }}">
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="is-right">
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
                        <td colspan="9" class="admin-reservations-empty">
                            Ainda não existem reservas.
                        </td>
                    </tr>

                @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
