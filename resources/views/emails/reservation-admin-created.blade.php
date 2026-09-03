<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Nova reserva #{{ $reservation->reservation_number }}
        — Tours N Fish
    </title>

</head>


<body style="
    margin:0;
    padding:0;
    background-color:#f4f7fa;
    font-family:Arial, Helvetica, sans-serif;
    color:#111827;
">


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        background-color:#f4f7fa;
        margin:0;
        padding:0;
    "
>

<tr>

<td
    align="center"
    style="
        padding:35px 15px;
    "
>


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        max-width:680px;
        margin:0 auto;
    "
>


{{-- =========================================================
     HEADER
========================================================== --}}

<tr>

<td
    align="center"
    style="
        background-color:#ffffff;
        padding:28px 30px 22px 30px;
        border-radius:14px 14px 0 0;
        border-bottom:1px solid #e5e7eb;
    "
>

    <img
        src="{{ url('images/logo/logo.png') }}"
        alt="Tours N Fish"
        width="170"
        style="
            display:block;
            width:170px;
            max-width:100%;
            height:auto;
            margin:0 auto;
            border:0;
        "
    >

    <div style="
        margin-top:8px;
        font-size:13px;
        color:#64748b;
        letter-spacing:0.2px;
    ">
        Fishing Tours in the Azores
    </div>

</td>

</tr>


{{-- =========================================================
     MAIN CONTENT
========================================================== --}}

<tr>

<td
    style="
        background-color:#ffffff;
        padding:34px 34px 38px 34px;
        border-radius:0 0 14px 14px;
    "
>


<p style="
    margin:0 0 10px 0;
    font-size:17px;
    line-height:1.6;
    color:#111827;
">
    Nova reserva recebida.
</p>


<p style="
    margin:0;
    font-size:15px;
    line-height:1.8;
    color:#475569;
">
    Foi submetida uma nova reserva através do website Tours N Fish.
</p>


{{-- =========================================================
     RESERVATION NUMBER / STATUS
========================================================== --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        margin:28px 0 30px 0;
        background-color:#eef5fb;
        border-radius:10px;
    "
>

<tr>

<td
    align="center"
    style="
        padding:22px 15px;
    "
>

    <div style="
        font-size:11px;
        font-weight:bold;
        letter-spacing:1.3px;
        color:#64748b;
        text-transform:uppercase;
    ">
        NÚMERO DA RESERVA
    </div>

    <div style="
        margin-top:7px;
        font-size:27px;
        line-height:1.2;
        font-weight:bold;
        color:#123b66;
    ">
        #{{ $reservation->reservation_number }}
    </div>

    <div style="
        margin-top:12px;
        display:inline-block;
        padding:6px 12px;
        background-color:#fff8e6;
        border-radius:20px;
        font-size:12px;
        font-weight:bold;
        color:#8a6400;
    ">
        Pendente de pagamento
    </div>

</td>

</tr>

</table>


{{-- =========================================================
     RESERVATION DATA
========================================================== --}}

<h2 style="
    margin:0 0 15px 0;
    font-size:20px;
    line-height:1.4;
    color:#123b66;
">
    Dados da reserva
</h2>


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        border-collapse:collapse;
        font-size:15px;
    "
>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Passeio
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->tour->translation()?->name ?? '—' }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Opção
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->option->translation()?->name ?? '—' }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Data
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ \Carbon\Carbon::parse($reservation->booking_date)->format('d/m/Y') }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Horário
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ substr($reservation->start_at, 0, 5) }}
    —
    {{ substr($reservation->end_at, 0, 5) }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    color:#64748b;
">
    Participantes
</td>

<td style="
    padding:12px 0;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->participants }}
</td>

</tr>


</table>


{{-- =========================================================
     CUSTOMER DATA
========================================================== --}}

<h2 style="
    margin:32px 0 15px 0;
    font-size:20px;
    line-height:1.4;
    color:#123b66;
">
    Dados do cliente
</h2>


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        border-collapse:collapse;
        font-size:15px;
    "
>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Nome
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->customer_name }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Email
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->customer_email }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    Telefone
</td>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->customer_phone }}
</td>

</tr>


<tr>

<td style="
    padding:12px 0;
    color:#64748b;
">
    Idioma
</td>

<td style="
    padding:12px 0;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ strtoupper($reservation->locale ?? 'pt') }}
</td>

</tr>


</table>


{{-- =========================================================
     PAYMENT
========================================================== --}}

<h2 style="
    margin:32px 0 15px 0;
    font-size:20px;
    line-height:1.4;
    color:#123b66;
">
    Pagamento
</h2>


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        background-color:#f8fafc;
        border:1px solid #e5e7eb;
        border-radius:10px;
    "
>

<tr>

<td style="
    padding:18px 20px;
">


<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="border-collapse:collapse;"
>


<tr>

<td style="
    padding:7px 0;
    color:#64748b;
">
    Total da reserva
</td>

<td style="
    padding:7px 0;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    €{{ number_format(
        (float) $reservation->total_amount,
        2,
        ',',
        '.'
    ) }}
</td>

</tr>


<tr>

<td style="
    padding:7px 0;
    color:#64748b;
">
    Sinal ({{ $reservation->deposit_percentage }}%)
</td>

<td style="
    padding:7px 0;
    text-align:right;
    font-size:18px;
    font-weight:bold;
    color:#123b66;
">
    €{{ number_format(
        (float) $reservation->deposit_amount,
        2,
        ',',
        '.'
    ) }}
</td>

</tr>


<tr>

<td style="
    padding:7px 0;
    color:#64748b;
">
    Prazo de pagamento
</td>

<td style="
    padding:7px 0;
    text-align:right;
    font-weight:bold;
    color:#111827;
">
    {{ $reservation->payment_deadline_at->format('d/m/Y H:i') }}
</td>

</tr>


</table>

</td>

</tr>

</table>


{{-- =========================================================
     CUSTOMER MESSAGE
========================================================== --}}

@if($reservation->customer_message)

<h2 style="
    margin:32px 0 15px 0;
    font-size:20px;
    line-height:1.4;
    color:#123b66;
">
    Observações do cliente
</h2>


<div style="
    padding:18px 20px;
    background-color:#f8fafc;
    border:1px solid #e5e7eb;
    border-radius:10px;
    font-size:14px;
    line-height:1.7;
    color:#475569;
">
    {{ $reservation->customer_message }}
</div>

@endif


{{-- =========================================================
     ADMIN CTA
========================================================== --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        margin-top:30px;
        background-color:#eef5fb;
        border-radius:11px;
    "
>

<tr>

<td
    align="center"
    style="
        padding:28px 20px 30px 20px;
    "
>

<h2 style="
    margin:0 0 9px 0;
    font-size:20px;
    line-height:1.4;
    color:#123b66;
">
    Consultar reserva
</h2>


<p style="
    margin:0 auto 22px auto;
    max-width:500px;
    font-size:14px;
    line-height:1.7;
    color:#475569;
">
    Consulte os detalhes da reserva e acompanhe o pagamento no painel de administração.
</p>


<table
    cellpadding="0"
    cellspacing="0"
    border="0"
    align="center"
>

<tr>

<td
    align="center"
    style="
        border-radius:7px;
        background-color:#f5b900;
    "
>

<a
    href="{{ route('admin.reservations.show', $reservation) }}"
    style="
        display:inline-block;
        padding:14px 30px;
        background-color:#f5b900;
        color:#123b66;
        text-decoration:none;
        border-radius:7px;
        font-size:15px;
        font-weight:bold;
    "
>
    Ver reserva no painel
</a>

</td>

</tr>

</table>


</td>

</tr>

</table>


{{-- =========================================================
     FOOTER
========================================================== --}}

<div style="
    margin-top:34px;
    padding-top:25px;
    border-top:1px solid #e5e7eb;
    text-align:center;
">


<img
    src="{{ url('images/logo/logo.png') }}"
    alt="Tours N Fish"
    width="125"
    style="
        display:block;
        width:125px;
        max-width:100%;
        height:auto;
        margin:0 auto 10px auto;
        border:0;
    "
>


<p style="
    margin:0;
    font-size:13px;
    line-height:1.6;
    color:#64748b;
">
    Esta é uma notificação automática de nova reserva.
</p>


<p style="
    margin:7px 0 0 0;
    font-size:13px;
    font-weight:bold;
    color:#123b66;
">
    Tours N Fish
</p>


</div>


</td>

</tr>


</table>


</td>

</tr>

</table>


</body>

</html>