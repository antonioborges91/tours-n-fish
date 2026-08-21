@extends('layouts.app')

@section('title', 'Reserva')

@section('content')

<section class="reservation-page">

    <div class="container-custom">

        <div class="reservation-success">

            <div class="reservation-success-icon">
                ✓
            </div>

            <h1>
                Pedido de reserva recebido
            </h1>

            <p>
                Obrigado, {{ $reservation->customer_name }}.
                O seu pedido de reserva foi registado.
            </p>

        </div>


        <div class="reservation-layout">

            {{-- Dados da reserva --}}

            <div class="reservation-card">

                <div class="reservation-card-header">

                    <h2>
                        Dados da reserva
                    </h2>

                </div>


                <div class="reservation-details">

                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Passeio
                        </span>

                        <strong>
                            {{ $reservation->tour->translation()->name }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Opção
                        </span>

                        <strong>
                            {{ $reservation->option->translation()->name }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Data
                        </span>

                        <strong>
                            {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d/m/Y') }}
                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Horário
                        </span>

                        <strong>

                            {{ substr($reservation->start_at, 0, 5) }}

                            —

                            {{ substr($reservation->end_at, 0, 5) }}

                        </strong>

                    </div>


                    <div class="reservation-detail">

                        <span class="reservation-label">
                            Pessoas
                        </span>

                        <strong>
                            {{ $reservation->participants }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- Estado e pagamento --}}

            <div class="reservation-card">

                <div class="reservation-card-header">

                    <h2>
                        Estado da reserva
                    </h2>

                </div>


                <div class="reservation-status">

                    @if($reservation->status === 'pending_payment')

                        <span class="reservation-status-badge pending">
                            Pendente de pagamento
                        </span>

                    @elseif($reservation->status === 'confirmed')

                        <span class="reservation-status-badge confirmed">
                            Reserva confirmada
                        </span>

                    @elseif($reservation->status === 'cancelled')

                        <span class="reservation-status-badge cancelled">
                            Reserva cancelada
                        </span>

                    @endif

                </div>


                <div class="reservation-payment">

                    <div>

                        <span>
                            Preço do passeio
                        </span>

                        <strong>
                            €{{ number_format($reservation->total_amount, 2, ',', '.') }}
                        </strong>

                    </div>


                    <div>

                        <span>
                            Sinal (10%)
                        </span>

                        <strong>
                            €{{ number_format($reservation->deposit_amount, 2, ',', '.') }}
                        </strong>

                    </div>

                </div>


                @if($reservation->status === 'pending_payment')

                    <div class="reservation-notice">

                        <strong>
                            Próximo passo
                        </strong>

                        <p>
                            Para confirmar a reserva deverá efetuar o
                            pagamento do sinal de
                            €{{ number_format($reservation->deposit_amount, 2, ',', '.') }}.
                        </p>

                        <p>
                            Após o pagamento poderá enviar o comprovativo
                            através do link que receberá por email.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- Referência pública --}}

        <div class="reservation-reference">

            <span>
                Referência da reserva
            </span>

            <strong>
                {{ $reservation->public_token }}
            </strong>

        </div>

    </div>

</section>


@push('styles')

<style>

.reservation-success {
    text-align: center;
    margin-bottom: 40px;
}

.reservation-success-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 20px;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    background: #dcfce7;
    color: #15803d;

    font-size: 30px;
    font-weight: 700;
}

.reservation-success h1 {
    margin: 0;

    font-size: 2.2rem;
    font-weight: 700;
}

.reservation-success p {
    margin-top: 10px;

    color: #6b7280;
    font-size: 1.05rem;
}

.reservation-status {
    margin-bottom: 25px;
}

.reservation-status-badge {
    display: inline-block;

    padding: 8px 14px;

    border-radius: 999px;

    font-size: 0.9rem;
    font-weight: 600;
}

.reservation-status-badge.pending {
    background: #fff7d6;
    color: #92400e;
}

.reservation-status-badge.confirmed {
    background: #dcfce7;
    color: #15803d;
}

.reservation-status-badge.cancelled {
    background: #fee2e2;
    color: #b91c1c;
}

.reservation-reference {
    margin-top: 25px;

    text-align: center;

    color: #6b7280;
}

.reservation-reference strong {
    display: block;

    margin-top: 5px;

    color: #374151;

    font-size: 0.85rem;

    word-break: break-all;
}

</style>

@endpush

@endsection