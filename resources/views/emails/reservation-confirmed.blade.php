@php
    app()->setLocale($reservation->locale ?? config('app.locale'));
@endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        {{ __('reservation.confirmed_title') }}
        #{{ $reservation->reservation_number }}
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


{{-- GREETING --}}

<p style="
    margin:0 0 14px 0;
    font-size:17px;
    line-height:1.6;
    color:#111827;
">
    {{ __('reservation.email_greeting', [
        'name' => $reservation->customer_name
    ]) }}
</p>


{{-- =========================================================
     CONFIRMATION MESSAGE
========================================================== --}}

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        margin:25px 0 30px 0;
        background-color:#eef5fb;
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
        color:#123b66;
        text-transform:uppercase;
    ">
        @if(app()->getLocale() === 'en')
            Booking confirmed
        @else
            Reserva confirmada
        @endif
    </div>

    <h1 style="
        margin:0 0 12px 0;
        font-size:25px;
        line-height:1.35;
        color:#123b66;
    ">
        {{ __('reservation.confirmed_title') }}
    </h1>

    <p style="
        margin:0;
        font-size:16px;
        line-height:1.7;
        color:#475569;
    ">
        {{ __('reservation.confirmed_message') }}
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
        {{ __('reservation.reservation_number') }}
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
     RESERVATION DATA
========================================================== --}}

<h2 style="
    margin:0 0 15px 0;
    font-size:20px;
    line-height:1.4;
    color:#123b66;
">
    {{ __('reservation.reservation_data') }}
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


{{-- TOUR --}}

<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    {{ __('reservation.tour') }}
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


{{-- OPTION --}}

<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    {{ __('reservation.option') }}
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


{{-- DATE --}}

<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    {{ __('reservation.date') }}
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


{{-- TIME --}}

<tr>

<td style="
    padding:12px 0;
    border-bottom:1px solid #e5e7eb;
    color:#64748b;
">
    {{ __('reservation.time') }}
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


{{-- PARTICIPANTS --}}

<tr>

<td style="
    padding:12px 0;
    color:#64748b;
">
    {{ __('reservation.participants') }}
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
     MANAGE RESERVATION
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
    {{ __('reservation.manage_reservation') }}
</h2>


<p style="
    margin:0 auto 22px auto;
    max-width:500px;
    font-size:14px;
    line-height:1.7;
    color:#475569;
">
    {{ __('reservation.manage_reservation_instruction') }}
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
    href="{{ route('reservations.show', $reservation->public_token) }}"
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
    {{ __('reservation.manage_reservation_button') }}
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
    {{ __('reservation.email_thank_you') }}
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