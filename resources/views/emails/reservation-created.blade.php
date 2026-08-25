<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        Reserva #{{ $reservation->reservation_number }} — Tours N Fish
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

            <!-- ========================================================= -->
            <!-- HEADER -->
            <!-- ========================================================= -->

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
                    Fishing Tours in the Azores
                </div>

            </div>


            <!-- ========================================================= -->
            <!-- CONTENT -->
            <!-- ========================================================= -->

            <div style="
                background-color:#ffffff;
                padding:35px 30px;
                border-radius:0 0 12px 12px;
            ">


                <!-- GREETING -->

                <p style="
                    margin:0 0 15px 0;
                    font-size:16px;
                    line-height:1.6;
                ">
                    Olá {{ $reservation->customer_name }},
                </p>


                <p style="
                    margin:0;
                    font-size:16px;
                    line-height:1.7;
                    color:#475569;
                ">
                    Recebemos o seu pedido de reserva.
                    A sua reserva foi criada com sucesso e encontra-se
                    atualmente a aguardar pagamento.
                </p>


                <!-- ===================================================== -->
                <!-- RESERVATION NUMBER -->
                <!-- ===================================================== -->

                <div style="
                    margin:28px 0;
                    padding:20px;
                    background-color:#eef5fb;
                    border-radius:9px;
                    text-align:center;
                ">

                    <div style="
                        font-size:12px;
                        font-weight:bold;
                        letter-spacing:1px;
                        color:#64748b;
                    ">
                        NÚMERO DA RESERVA
                    </div>

                    <div style="
                        margin-top:7px;
                        font-size:27px;
                        font-weight:bold;
                        color:#123b66;
                    ">
                        #{{ $reservation->reservation_number }}
                    </div>

                </div>


                <!-- ===================================================== -->
                <!-- RESERVATION SUMMARY -->
                <!-- ===================================================== -->

                <h2 style="
                    margin:30px 0 15px 0;
                    font-size:20px;
                    color:#123b66;
                ">
                    Resumo da reserva
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

                    <!-- TOUR -->

                    <tr>

                        <td style="
                            padding:11px 0;
                            border-bottom:1px solid #e5e7eb;
                            color:#64748b;
                            vertical-align:top;
                        ">
                            Passeio
                        </td>

                        <td style="
                            padding:11px 0;
                            border-bottom:1px solid #e5e7eb;
                            text-align:right;
                            font-weight:bold;
                            color:#1f2937;
                            vertical-align:top;
                        ">
                            {{ $reservation->tour->translation()?->name ?? '—' }}
                        </td>

                    </tr>


                    <!-- OPTION -->

                    <tr>

                        <td style="
                            padding:11px 0;
                            border-bottom:1px solid #e5e7eb;
                            color:#64748b;
                            vertical-align:top;
                        ">
                            Opção
                        </td>

                        <td style="
                            padding:11px 0;
                            border-bottom:1px solid #e5e7eb;
                            text-align:right;
                            font-weight:bold;
                            color:#1f2937;
                            vertical-align:top;
                        ">
                            {{ $reservation->option->translation()?->name ?? '—' }}
                        </td>

                    </tr>


                    <!-- DATE -->

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
                            {{ $reservation->booking_date->format('d/m/Y') }}
                        </td>

                    </tr>


                    <!-- SCHEDULE -->

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
                            -
                            {{ substr($reservation->end_at, 0, 5) }}
                        </td>

                    </tr>


                    <!-- PARTICIPANTS -->

                    <tr>

                        <td style="
                            padding:11px 0;
                            color:#64748b;
                        ">
                            Participantes
                        </td>

                        <td style="
                            padding:11px 0;
                            text-align:right;
                            font-weight:bold;
                        ">
                            {{ $reservation->participants }}
                        </td>

                    </tr>

                </table>


                <!-- ===================================================== -->
                <!-- PAYMENT -->
                <!-- ===================================================== -->

                <h2 style="
                    margin:32px 0 15px 0;
                    font-size:20px;
                    color:#123b66;
                ">
                    Pagamento
                </h2>


                <div style="
                    padding:20px;
                    background-color:#f8fafc;
                    border:1px solid #e5e7eb;
                    border-radius:9px;
                ">

                    <table
                        width="100%"
                        cellpadding="0"
                        cellspacing="0"
                        style="border-collapse:collapse;"
                    >

                        <!-- TOTAL -->

                        <tr>

                            <td style="
                                padding:7px 0;
                                color:#64748b;
                            ">
                                Valor total
                            </td>

                            <td style="
                                padding:7px 0;
                                text-align:right;
                                font-weight:bold;
                            ">
                                €{{ number_format((float) $reservation->total_amount, 2, ',', '.') }}
                            </td>

                        </tr>


                        <!-- DEPOSIT -->

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
                                €{{ number_format((float) $reservation->deposit_amount, 2, ',', '.') }}
                            </td>

                        </tr>


                        <!-- DEADLINE -->

                        <tr>

                            <td style="
                                padding:7px 0;
                                color:#64748b;
                            ">
                                Prazo para pagamento
                            </td>

                            <td style="
                                padding:7px 0;
                                text-align:right;
                                font-weight:bold;
                            ">
                                {{ $reservation->payment_deadline_at->format('d/m/Y H:i') }}
                            </td>

                        </tr>

                    </table>

                </div>


                <!-- ===================================================== -->
                <!-- MANAGE RESERVATION -->
                <!-- ===================================================== -->

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
                        Confirme a sua reserva
                    </h2>


                    <p style="
                        margin:0 auto 22px auto;
                        max-width:500px;
                        font-size:15px;
                        line-height:1.7;
                        color:#475569;
                    ">
                        Efetue o pagamento do sinal e envie o comprovativo
                        através da sua página de reserva.
                    </p>


                    <a
                        href="{{ route('reservations.show', $reservation->public_token) }}"
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
                        GERIR A MINHA RESERVA
                    </a>

                </div>


                <!-- ===================================================== -->
                <!-- CHANGE RESERVATION -->
                <!-- ===================================================== -->

                <div style="
                    margin-top:32px;
                    padding-top:25px;
                    border-top:1px solid #e5e7eb;
                ">

                    <h3 style="
                        margin:0 0 10px 0;
                        font-size:17px;
                        color:#123b66;
                    ">
                        Precisa de alterar a sua reserva?
                    </h3>


                    <p style="
                        margin:0;
                        font-size:14px;
                        line-height:1.7;
                        color:#475569;
                    ">
                        Caso pretenda alterar a data ou horário da sua reserva,
                        por favor contacte a administração antes de efetuar
                        qualquer alteração.
                    </p>


                    <p style="
                        margin:12px 0 0 0;
                        font-size:14px;
                        line-height:1.7;
                        color:#475569;
                    ">
                        Se a reserva ainda não tiver sido paga, poderá também
                        cancelar a reserva e efetuar um novo pedido de reserva
                        para a data pretendida.
                    </p>

                </div>


                <!-- ===================================================== -->
                <!-- PAYMENT DEADLINE NOTICE -->
                <!-- ===================================================== -->

                <div style="
                    margin-top:25px;
                    padding:16px;
                    background-color:#fff8e6;
                    border-radius:8px;
                ">

                    <p style="
                        margin:0;
                        font-size:13px;
                        line-height:1.7;
                        color:#7c5a00;
                    ">
                        Esta reserva encontra-se atualmente a aguardar pagamento.
                        Se o pagamento não for efetuado dentro do prazo indicado,
                        a reserva poderá ser automaticamente expirada.
                    </p>

                </div>


                <!-- ===================================================== -->
                <!-- FOOTER -->
                <!-- ===================================================== -->

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
                        Obrigado por escolher a Tours N Fish.
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