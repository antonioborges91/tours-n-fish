<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">

    <title>
        Reserva #{{ $reservation->reservation_number }} — Tours N Fish
    </title>
</head>

<body style="margin:0; padding:0; background:#f5f7fa; font-family:Arial, Helvetica, sans-serif; color:#1f2937;">

<div style="max-width:700px; margin:30px auto; background:#ffffff; padding:35px; border-radius:10px;">

    <h1 style="margin-top:0;">
        Tours N Fish
    </h1>

    <p>
        Olá {{ $reservation->customer_name }},
    </p>

    <p>
        Recebemos o seu pedido de reserva.
    </p>

    <h2>
        Reserva #{{ $reservation->reservation_number }}
    </h2>

    <p>
        <strong>Data:</strong>
        {{ $reservation->booking_date->format('d/m/Y') }}
    </p>

    <p>
        <strong>Horário:</strong>
        {{ substr($reservation->start_at, 0, 5) }}
        -
        {{ substr($reservation->end_at, 0, 5) }}
    </p>

    <p>
        <strong>Participantes:</strong>
        {{ $reservation->participants }}
    </p>

    <hr>

    <h3>Pagamento</h3>

    <p>
        <strong>Valor total:</strong>
        €{{ number_format((float) $reservation->total_amount, 2, ',', '.') }}
    </p>

    <p>
        <strong>Sinal ({{ $reservation->deposit_percentage }}%):</strong>
        €{{ number_format((float) $reservation->deposit_amount, 2, ',', '.') }}
    </p>

    <p>
        <strong>Prazo para pagamento:</strong>
        {{ $reservation->payment_deadline_at->format('d/m/Y H:i') }}
    </p>

    <p>
        Para confirmar a sua reserva, deverá efetuar o pagamento do sinal.
    </p>

    <p style="margin-top:35px;">
        Obrigado,<br>
        <strong>Tours N Fish</strong>
    </p>

</div>

</body>
</html>