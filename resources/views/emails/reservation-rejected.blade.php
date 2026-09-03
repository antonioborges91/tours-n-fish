@php
    $locale = $reservation->locale ?? config('app.locale');
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        @if($locale === 'en')
            Booking #{{ $reservation->reservation_number }} — Payment proof rejected — Tours N Fish
        @else
            Reserva #{{ $reservation->reservation_number }} — Comprovativo rejeitado — Tours N Fish
        @endif
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


{{-- GREETING --}}

<p style="
    margin:0 0 14px 0;
    font-size:17px;
    line-height:1.6;
    color:#111827;
">

    @if($locale === 'en')
        Dear {{ $reservation->customer_name }},
    @else
        Caro(a) {{ $reservation->customer_name }},
    @endif

</p>


{{-- =========================================================
     REJECTION MESSAGE
========================================================== --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        margin:25px 0 30px 0;
        background-color:#fef2f2;
        border-radius:10px;
    "
>

<tr>

<td
    align="center"
    style="
        padding:25px 20px;
    "
>

    <div style="
        margin-bottom:12px;
        font-size:12px;
        font-weight:bold;
        letter-spacing:1.2px;
        color:#b91c1c;
        text-transform:uppercase;
    ">
        @if($locale === 'en')
            Payment not accepted
        @else
            Pagamento não aceite
        @endif
    </div>


    <h1 style="
        margin:0 0 12px 0;
        font-size:25px;
        line-height:1.35;
        color:#b91c1c;
    ">
        @if($locale === 'en')
            Payment proof rejected
        @else
            Comprovativo de pagamento rejeitado
        @endif
    </h1>


    <p style="
        margin:0;
        font-size:16px;
        line-height:1.7;
        color:#475569;
    ">

        @if($locale === 'en')
            The payment proof submitted for booking
            #{{ $reservation->reservation_number }}
            could not be accepted and, as a result, your booking has been cancelled.
        @else
            O comprovativo de pagamento enviado para a reserva
            #{{ $reservation->reservation_number }}
            não pôde ser aceite e, por esse motivo, a sua reserva foi cancelada.
        @endif

    </p>

</td>

</tr>

</table>


{{-- =========================================================
     RESERVATION NUMBER
========================================================== --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        margin:0 0 30px 0;
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
        @if($locale === 'en')
            Booking number
        @else
            Número da reserva
        @endif
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

</td>

</tr>

</table>


{{-- =========================================================
     NEXT STEPS
========================================================== --}}

<p style="
    margin:0 0 15px 0;
    font-size:16px;
    line-height:1.7;
    color:#475569;
">

    @if($locale === 'en')
        If you would still like to join this tour, you will need to make a new booking through our website.
    @else
        Se ainda pretender realizar este passeio, deverá efetuar uma nova reserva através do nosso website.
    @endif

</p>


<p style="
    margin:0;
    font-size:16px;
    line-height:1.7;
    color:#475569;
">

    @if($locale === 'en')
        Availability will be checked again when you make the new booking.
    @else
        A disponibilidade será novamente verificada no momento da nova reserva.
    @endif

</p>


{{-- =========================================================
     NEW BOOKING CTA
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

    @if($locale === 'en')
        Make a new booking
    @else
        Fazer uma nova reserva
    @endif

</h2>


<p style="
    margin:0 auto 22px auto;
    max-width:500px;
    font-size:14px;
    line-height:1.7;
    color:#475569;
">

    @if($locale === 'en')
        Please use our website to choose a new date and time.
    @else
        Utilize o nosso website para escolher uma nova data e horário.
    @endif

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
    href="{{ url('/') }}"
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

    @if($locale === 'en')
        Make a new booking
    @else
        Fazer nova reserva
    @endif

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

    @if($locale === 'en')
        Thank you for your understanding.
    @else
        Obrigado pela sua compreensão.
    @endif

</p>


<p style="
    margin:7px 0 0 0;
    font-size:13px;
    font-weight:bold;
    color:#123b66;
">
    Fishing Tours in the Azores
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