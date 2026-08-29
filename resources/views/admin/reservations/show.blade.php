@extends('layouts.admin')

@section('content')

<div class="admin-page admin-reservation-show-page">

    <div class="admin-page-header">
        <div>
            <h1>Reserva #{{ $reservation->reservation_number }}</h1>
            <p>Detalhes da reserva e informação do cliente.</p>
        </div>

        <a
            href="{{ route('admin.reservations.index') }}"
            class="admin-btn-secondary"
        >
            ← Voltar às reservas
        </a>
    </div>

    @php
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

    <div class="admin-reservation-grid">

        {{-- RESERVA --}}
        <div class="admin-card">

            <div class="admin-card-header">
                <div>
                    <span class="admin-card-label">Reserva</span>
                    <h2>
                        {{ $reservation->tour?->translation()?->name ?? '—' }}
                    </h2>
                </div>

                <span class="admin-status admin-status-{{ $reservation->status }}">
                    {{ $statusLabel }}
                </span>
            </div>

            <div class="admin-detail-list">

                <div class="admin-detail-row">
                    <span>Passeio</span>
                    <strong>
                        {{ $reservation->tour?->translation()?->name ?? '—' }}
                    </strong>
                </div>

                <div class="admin-detail-row">
                    <span>Opção</span>
                    <strong>
                        {{ $reservation->option?->translation()?->name ?? '—' }}
                    </strong>
                </div>

                <div class="admin-detail-row">
                    <span>Data</span>
                    <strong>
                        {{ $reservation->booking_date?->format('d/m/Y') ?? '—' }}
                    </strong>
                </div>

                <div class="admin-detail-row">
                    <span>Horário</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($reservation->start_at)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($reservation->end_at)->format('H:i') }}
                    </strong>
                </div>

                <div class="admin-detail-row">
                    <span>Pessoas</span>
                    <strong>{{ $reservation->participants }}</strong>
                </div>

            </div>

        </div>

        {{-- CLIENTE --}}
        <div class="admin-card">

            <div class="admin-card-header">
                <div>
                    <span class="admin-card-label">Cliente</span>
                    <h2>Dados do cliente</h2>
                </div>
            </div>

            <div class="admin-detail-list">

                <div class="admin-detail-row">
                    <span>Nome</span>
                    <strong>{{ $reservation->customer_name }}</strong>
                </div>

                <div class="admin-detail-row">
                    <span>Email</span>
                    <strong>{{ $reservation->customer_email }}</strong>
                </div>

                <div class="admin-detail-row">
                    <span>Telefone</span>
                    <strong>{{ $reservation->customer_phone }}</strong>
                </div>

                <div class="admin-detail-row admin-detail-row-column">
                    <span>Observações</span>
                    <p>
                        {{ $reservation->customer_message ?: 'Sem observações.' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- PAGAMENTO --}}
        <div class="admin-card">

            <div class="admin-card-header">
                <div>
                    <span class="admin-card-label">Pagamento</span>
                    <h2>Valores e comprovativo</h2>
                </div>
            </div>

            <div class="admin-detail-list">

                <div class="admin-detail-row">
                    <span>Total da reserva</span>
                    <strong>
                        €{{ number_format($reservation->total_amount, 2, ',', '.') }}
                    </strong>
                </div>

                <div class="admin-detail-row">
                    <span>
                        Sinal ({{ number_format($reservation->deposit_percentage, 0) }}%)
                    </span>
                    <strong>
                        €{{ number_format($reservation->deposit_amount, 2, ',', '.') }}
                    </strong>
                </div>

                <div class="admin-detail-row">
                    <span>Prazo de pagamento</span>
                    <strong>
                        {{ $reservation->payment_deadline_at
                            ? $reservation->payment_deadline_at->format('d/m/Y H:i')
                            : '—'
                        }}
                    </strong>
                </div>

            </div>

            <div class="admin-payment-proof">

                <div>
                    <span class="admin-card-label">Comprovativo</span>

                    @if($reservation->payment_proof)
                        <strong class="admin-payment-proof-status is-sent">
                            Recebido
                        </strong>

                        <a
                            href="{{ route('admin.reservations.payment-proof', $reservation) }}"
                            class="admin-btn-secondary"
                            target="_blank"
                        >
                            Ver comprovativo
                        </a>
                    @else
                        <strong class="admin-payment-proof-status">
                            Não enviado
                        </strong>
                    @endif
                </div>

                @if($reservation->payment_proof)
                    <a
                        href="{{ route('admin.reservations.payment-proof', $reservation) }}"
                        target="_blank"
                        rel="noopener"
                        class="admin-payment-proof-button"
                    >
                        Ver comprovativo
                    </a>
                @endif

            </div>

        </div>

        {{-- ESTADO --}}
        <div class="admin-card">

            <div class="admin-card-header">
                <div>
                    <span class="admin-card-label">Estado</span>
                    <h2>Histórico da reserva</h2>
                </div>
            </div>

            <div class="admin-detail-list">

                <div class="admin-detail-row">
                    <span>Estado atual</span>
                    <strong>{{ $statusLabel }}</strong>
                </div>

                <div class="admin-detail-row">
                    <span>Pedido criado em</span>
                    <strong>
                        {{ $reservation->created_at?->format('d/m/Y H:i') ?? '—' }}
                    </strong>
                </div>

                @if($reservation->payment_submitted_at)
                    <div class="admin-detail-row">
                        <span>Comprovativo enviado em</span>
                        <strong>
                            {{ $reservation->payment_submitted_at->format('d/m/Y H:i') }}
                        </strong>
                    </div>
                @endif

                @if($reservation->confirmed_at)
                    <div class="admin-detail-row">
                        <span>Confirmada em</span>
                        <strong>
                            {{ $reservation->confirmed_at->format('d/m/Y H:i') }}
                        </strong>
                    </div>
                @endif

                @if($reservation->cancelled_at)
                    <div class="admin-detail-row">
                        <span>Cancelada em</span>
                        <strong>
                            {{ $reservation->cancelled_at->format('d/m/Y H:i') }}
                        </strong>
                    </div>
                @endif

            </div>

        </div>

    </div>

</div>

@endsection
