@extends('layouts.admin')

@section('content')

<div class="admin-page admin-reservation-show-page">

    <div class="admin-page-header">

        <div>
            <h1>
                Reserva #{{ $reservation->reservation_number }}
            </h1>

            <p>
                Detalhes da reserva e informação do cliente.
            </p>
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

        $hasRemainingDayBlock =
            $reservation->blockedPeriods->isNotEmpty();

    @endphp


    <div class="admin-reservation-grid">


        {{-- =========================================================
            RESERVA
        ========================================================== --}}

        <div class="admin-card">

            <div class="admin-card-header">

                <div>

                    <span class="admin-card-label">
                        Reserva
                    </span>

                    <h2>
                        {{ $reservation->tour?->translation()?->name ?? '—' }}
                    </h2>

                </div>

                <span
                    class="admin-status admin-status-{{ $reservation->status }}"
                >
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

                    <strong>
                        {{ $reservation->participants }}
                    </strong>

                </div>

            </div>

        </div>



        {{-- =========================================================
            CLIENTE
        ========================================================== --}}

        <div class="admin-card">

            <div class="admin-card-header">

                <div>

                    <span class="admin-card-label">
                        Cliente
                    </span>

                    <h2>
                        Dados do cliente
                    </h2>

                </div>

            </div>


            <div class="admin-detail-list">

                <div class="admin-detail-row">

                    <span>Nome</span>

                    <strong>
                        {{ $reservation->customer_name }}
                    </strong>

                </div>


                <div class="admin-detail-row">

                    <span>Email</span>

                    <strong>
                        {{ $reservation->customer_email }}
                    </strong>

                </div>


                <div class="admin-detail-row">

                    <span>Telefone</span>

                    <strong>
                        {{ $reservation->customer_phone }}
                    </strong>

                </div>


                <div class="admin-detail-row admin-detail-row-column">

                    <span>Observações</span>

                    <p>
                        {{ $reservation->customer_message ?: 'Sem observações.' }}
                    </p>

                </div>

            </div>

        </div>



        {{-- =========================================================
            PAGAMENTO
        ========================================================== --}}

        <div class="admin-card">

            <div class="admin-card-header">

                <div>

                    <span class="admin-card-label">
                        Pagamento
                    </span>

                    <h2>
                        Valores e comprovativo
                    </h2>

                </div>

            </div>


            <div class="admin-detail-list">

                <div class="admin-detail-row">

                    <span>
                        Total da reserva
                    </span>

                    <strong>
                        €{{ number_format(
                            $reservation->total_amount,
                            2,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="admin-detail-row">

                    <span>
                        Sinal
                        ({{ number_format(
                            $reservation->deposit_percentage,
                            0
                        ) }}%)
                    </span>

                    <strong>
                        €{{ number_format(
                            $reservation->deposit_amount,
                            2,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="admin-detail-row">

                    <span>
                        Prazo de pagamento
                    </span>

                    <strong>

                        {{ $reservation->payment_deadline_at
                            ? $reservation->payment_deadline_at->format('d/m/Y H:i')
                            : '—'
                        }}

                    </strong>

                </div>

            </div>


            {{-- COMPROVATIVO --}}

            <div class="admin-payment-proof">

                <div>

                    <span class="admin-card-label">
                        Comprovativo
                    </span>


                    @if($reservation->payment_proof)

                        <strong class="admin-payment-proof-status is-sent">
                            Recebido
                        </strong>

                    @else

                        <strong class="admin-payment-proof-status">
                            Não enviado
                        </strong>

                    @endif

                </div>


                @if($reservation->payment_proof)

                    <a
                        href="{{ route(
                            'admin.reservations.payment-proof',
                            $reservation
                        ) }}"
                        target="_blank"
                        rel="noopener"
                        class="admin-payment-proof-button"
                    >
                        Ver comprovativo
                    </a>

                @endif

            </div>



            {{-- =====================================================
                AÇÕES ADMINISTRATIVAS
            ====================================================== --}}

            <div class="admin-reservation-actions">


                {{-- =================================================
                    CONFIRMAR / REJEITAR PAGAMENTO
                ================================================== --}}

                @if(
                    $reservation->status === 'payment_submitted'
                    && $reservation->payment_proof
                )

                    <form
                        method="POST"
                        action="{{ route(
                            'admin.reservations.confirm-payment',
                            $reservation
                        ) }}"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="admin-reservation-action admin-reservation-action-confirm"
                        >
                            Confirmar pagamento
                        </button>

                    </form>


                    <form
                        method="POST"
                        action="{{ route(
                            'admin.reservations.reject-payment',
                            $reservation
                        ) }}"
                        onsubmit="return confirm(
                            'Tem a certeza que pretende rejeitar este comprovativo? A reserva ficará marcada como rejeitada e o cliente terá de efetuar uma nova reserva.'
                        )"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="admin-reservation-action admin-reservation-action-reject"
                        >
                            Rejeitar comprovativo
                        </button>

                    </form>

                @endif



                {{-- =================================================
                    BLOQUEAR RESTANTE DO DIA
                ================================================== --}}

                @if(
                    $reservation->status === 'confirmed'
                    && ! $hasRemainingDayBlock
                )

                    <form
                        method="POST"
                        action="{{ route(
                            'admin.reservations.block-remaining-day',
                            $reservation
                        ) }}"
                        onsubmit="return confirm(
                            'Pretende bloquear o restante do dia para esta reserva? Os períodos fora do horário da reserva ficarão indisponíveis para novos passeios.'
                        )"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="admin-reservation-action admin-reservation-action-block"
                        >
                            Bloquear restante do dia
                        </button>

                    </form>

                @endif



                {{-- =================================================
                    CANCELAR RESERVA
                ================================================== --}}

                @if(in_array($reservation->status, [
                    'pending_payment',
                    'payment_submitted',
                    'confirmed',
                ], true))

                    <form
                        method="POST"
                        action="{{ route(
                            'admin.reservations.cancel',
                            $reservation
                        ) }}"
                        onsubmit="return confirm(
                            '{{ $reservation->status === 'confirmed'
                                ? 'Esta reserva está confirmada. Tem a certeza que pretende cancelar a reserva? A reserva será mantida na base de dados com o estado "Cancelada".'
                                : 'Tem a certeza que pretende cancelar esta reserva? A reserva será mantida na base de dados com o estado "Cancelada".'
                            }}'
                        )"
                    >

                        @csrf

                        <button
                            type="submit"
                            class="admin-reservation-action admin-reservation-action-cancel"
                        >
                            Cancelar reserva
                        </button>

                    </form>

                @endif



                {{-- =================================================
                    ELIMINAR RESERVA
                ================================================== --}}

                <form
                    method="POST"
                    action="{{ route(
                        'admin.reservations.destroy',
                        $reservation
                    ) }}"
                    onsubmit="return confirm(
                        '{{ $reservation->payment_proof
                            ? 'ATENÇÃO: esta reserva tem um comprovativo de pagamento associado. A reserva e o respetivo comprovativo serão eliminados definitivamente. Esta ação não pode ser desfeita.'
                            : 'Tem a certeza que pretende eliminar esta reserva? Esta ação não pode ser desfeita.'
                        }}'
                    )"
                >

                    @csrf

                    @method('DELETE')

                    <button
                        type="submit"
                        class="admin-reservation-action admin-reservation-action-delete"
                    >
                        Eliminar reserva
                    </button>

                </form>

            </div>

        </div>



        {{-- =========================================================
            ESTADO
        ========================================================== --}}

        <div class="admin-card">

            <div class="admin-card-header">

                <div>

                    <span class="admin-card-label">
                        Estado
                    </span>

                    <h2>
                        Histórico da reserva
                    </h2>

                </div>

            </div>


            <div class="admin-detail-list">

                <div class="admin-detail-row">

                    <span>
                        Estado atual
                    </span>

                    <strong>
                        {{ $statusLabel }}
                    </strong>

                </div>


                <div class="admin-detail-row">

                    <span>
                        Pedido criado em
                    </span>

                    <strong>
                        {{ $reservation->created_at?->format('d/m/Y H:i') ?? '—' }}
                    </strong>

                </div>


                @if($reservation->payment_submitted_at)

                    <div class="admin-detail-row">

                        <span>
                            Comprovativo enviado em
                        </span>

                        <strong>
                            {{ $reservation->payment_submitted_at->format('d/m/Y H:i') }}
                        </strong>

                    </div>

                @endif


                @if($reservation->confirmed_at)

                    <div class="admin-detail-row">

                        <span>
                            Confirmada em
                        </span>

                        <strong>
                            {{ $reservation->confirmed_at->format('d/m/Y H:i') }}
                        </strong>

                    </div>

                @endif


                @if($reservation->cancelled_at)

                    <div class="admin-detail-row">

                        <span>
                            Cancelada em
                        </span>

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