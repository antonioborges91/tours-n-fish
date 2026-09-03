<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Nova reserva #{{ $reservation->reservation_number }} — Tours N Fish
    </title>

</head>

<body style="
    margin:0;
    padding:0;
    background-color:#f3f6f9;
    font-family:Arial, Helvetica, sans-serif;
    color:#1f2937;
">

<div style="
    width:100%;
    padding:35px 15px;
    box-sizing:border-box;
">

<div style="
    max-width:650px;
    margin:0 auto;
">

<div style="
    background-color:#123b66;
    padding:30px;
    border-radius:12px 12px 0 0;
    text-align:center;
">

    <div style="
        font-size:28px;
        font-weight:bold;
        color:#ffffff;
        letter-spacing:0.3px;
    ">
        Tours N Fish
    </div>

    <div style="
        margin-top:8px;
        font-size:14px;
        color:#dbeafe;
    ">
        Nova reserva recebida
    </div>

</div>

<div style="
    background-color:#ffffff;
    padding:35px 30px;
    border-radius:0 0 12px 12px;
">

<div style="
    margin:0 0 25px 0;
    padding:24px;
    background-color:#eef5fb;
    border-radius:10px;
    text-align:center;
">

    <h1 style="
        margin:0 0 10px 0;
        font-size:24px;
        color:#123b66;
    ">
        Nova reserva
    </h1>

    <div style="
        font-size:27px;
        font-weight:bold;
        color:#123b66;
    ">
        #{{ $reservation->reservation_number }}
    </div>

</div>

<p style="
    margin:0 0 25px 0;
    font-size:16px;
    line-height:1.6;
">
    Foi recebida uma nova reserva através do website.
</p>

<h2 style="
    margin:30px 0 15px 0;
    font-size:20px;
    color:#123b66;
">
    Dados do cliente
</h2>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="
        border-collapse:collapse;
        font-size:15px;
    "
>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Nome
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ $reservation->customer_name }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Email
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ $reservation->customer_email }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Telefone
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ $reservation->customer_phone }}
    </td>
</tr>

</table>

<h2 style="
    margin:30px 0 15px 0;
    font-size:20px;
    color:#123b66;
">
    Dados da reserva
</h2>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    style="
        border-collapse:collapse;
        font-size:15px;
    "
>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Passeio
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ $reservation->tour->translation()?->name ?? '—' }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Opção
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ $reservation->option->translation()?->name ?? '—' }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Data
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d/m/Y') }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Horário
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ substr($reservation->start_at, 0, 5) }}
        —
        {{ substr($reservation->end_at, 0, 5) }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        color:#64748b;
    ">
        Participantes
    </td>

    <td style="
        padding:11px 0;
        border-bottom:1px solid #e5e7eb;
        text-align:right;
        font-weight:bold;
    ">
        {{ $reservation->participants }}
    </td>
</tr>

<tr>
    <td style="
        padding:11px 0;
        color:#64748b;
    ">
        Estado
    </td>

    <td style="
        padding:11px 0;
        text-align:right;
        font-weight:bold;
    ">
        @switch($reservation->status)

            @case('pending_payment')
                A aguardar pagamento
                @break

            @case('payment_submitted')
                Comprovativo enviado
                @break

            @case('confirmed')
                Confirmada
                @break

            @case('rejected')
                Rejeitada
                @break

            @case('cancelled')
                Cancelada
                @break

            @case('expired')
                Expirada
                @break

            @default
                {{ $reservation->status }}

        @endswitch
    </td>
</tr>

</table>

@if($reservation->customer_notes)
    <h2 style="
        margin:30px 0 15px 0;
        font-size:20px;
        color:#123b66;
    ">
        Observações do cliente
    </h2>

    <div style="
        padding:18px;
        background-color:#f8fafc;
        border-radius:8px;
        font-size:15px;
        line-height:1.7;
        color:#475569;
    ">
        {{ $reservation->customer_notes }}
    </div>
@endif

<div style="
    margin:35px 0 0 0;
    padding:27px 20px;
    background-color:#eef5fb;
    border-radius:10px;
    text-align:center;
">

    <h2 style="
        margin:0 0 10px 0;
        font-size:20px;
        color:#123b66;
    ">
        Consultar reserva
    </h2>

    <p style="
        margin:0 auto 22px auto;
        max-width:500px;
        font-size:15px;
        line-height:1.7;
        color:#475569;
    ">
        Pode consultar os detalhes desta reserva no painel de administração.
    </p>

    <a
        href="{{ route('admin.reservations.show', $reservation) }}"
        style="
            display:inline-block;
            padding:14px 28px;
            background-color:#123b66;
            color:#ffffff;
            text-decoration:none;
            border-radius:7px;
            font-size:15px;
            font-weight:bold;
        "
    >
        Ver reserva no painel
    </a>

</div>

<div style="
    margin-top:35px;
    padding-top:25px;
    border-top:1px solid #e5e7eb;
    text-align:center;
">

    <p style="
        margin:0;
        font-size:14px;
        line-height:1.6;
        color:#64748b;
    ">
        Esta é uma notificação automática de nova reserva.
    </p>

    <p style="
        margin:8px 0 0 0;
        font-size:14px;
        font-weight:bold;
        color:#123b66;
    ">
        Tours N Fish
    </p>

</div>

</div>
</div>
</div>

</body>
</html>