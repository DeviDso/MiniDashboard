<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Quote</title>
        {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> --}}
        <style>
        /* @import url('https://fonts.googleapis.com/css?family=Open+Sans'); */
            body {
                font-family: DejaVu Sans, sans-serif;
                line-height: 15px!important;
            }
            .center{
                text-align: center
            }
            /* .full{
                width: 100%;
                float: left;
            } */
            .half{
                width: 50%;
                float: left;
            }
            table tr th{
                font-weight: 400;
                /* background: #333; */
                color: #333;
                /* border-bottom: solid 1px #ddd; */
            }
            table tr:nth-child(even){
                background: #f6f6f6;
            }
            table.main{
                /* border: 0.9px solid #ddd; */
            }
        </style>

        </head>
    @php
        $totalWeight = 0.00;
        $totalPrice = 0.00;
        $netWeight = 0.00;
        $finalPrice = 0.00;
    @endphp
    <body>
        <div style="width: 100%; text-align: center">
            <img src="http://desam.lt/ppp-logo.png" height="75">
        </div>
        <div class="center" style="margin-top: 35px">
            <h5>Užsakymo nr. {{ $quote->id }}</h5>
            <h6 style="margin-top: -15px">{{ substr($quote->created_at, 0, 10) }}</h6>
        </div>
        <div id="top_table">
            <table width="100%" class="main">
                <tr>
                    <td style="width: 50%!important;font-size: 11px;">
                        <h2>{{ $quote->client->name }}</h2>
                        <b>PVM</b>: {{ $quote->client->vat }}<br>
                        <b>Tel</b>: {{ $quote->client->phone}} <br>
                        <b>El. paštas</b>: {{ $quote->client->email }} <br>
                        <b>Adresas:</b><br>
                        {{ $quote->client->street . ' ' . $quote->client->post_code . ', ' . $quote->client->city . ', ' . $quote->client->country }} <br>
                        <b>Pristatymo adresas:</b><br>
                        {{ $quote->client->delivery_street . ' ' . $quote->client->delivery_post_code . ', ' . $quote->client->delivery_city . ', ' . $quote->client->delivery_country }} <br>
                    </td>
                    <td style="font-size: 11px">
                        <h2>Power Parts Pro UAB</h2>
                        <b>Įm. kodas:</b> 302784671<br>
                        <b>PVM:</b> LT100006906012<br>
                        <b>Tel:</b> 0037060884059<br>
                        <b>Reg. adresas</b>: Ateities pl. 31, 52167, Kaunas, Lithuania<br>
                        <b>Bankas:</b> Swedbank AB<br>
                        <b>Sąsk. nr:</b> LT31 7300 0101 3188 2929<br>
                        <b>BIC/SWIFT:</b> HABALT22
                    </td>
                </tr>
            </table>
        </div>
        <table width="100%" style="font-size: 12px; margin-top: 25px">
            <tr style="background: #555!important; color: #fff!important">
                <th style="font-weight: 600">Detalės nr.</th>
                <th style="font-weight: 600">Aprašymas</th>
                <th style="font-weight: 600">Kiekis</th>
                <th style="font-weight: 600">Vnt. svoris</th>
                <th style="font-weight: 600">Viso svoris</th>
                <th style="font-weight: 600">Kaina</th>
                <th style="font-weight: 600">Viso kaina</th>
            </tr>
            @foreach($quote->data as $index => $d)
                @php
                    $totalWeight = $totalWeight + $d->bruto;
                    $totalPrice = $totalPrice + $d->price;
                    $netWeight = $netWeight + $d->netto;
                    $finalPrice = $finalPrice + $d->price;
                @endphp
                <tr>
                    <td>{{ $d->code }}</td>§
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->quantity }}</td>
                    <td>{{ ($d->bruto != '') ? $d->bruto : '-' }}</td>
                    <td>{{ sprintf('%0.2f', $totalWeight) }}</td>
                    <td>{{ $d->price }} {{ ($currency == 'EUR') ? '&euro;' : '$'}}</td>
                    <td>{{ sprintf('%0.2f', $totalPrice * $d->quantity) }} {{ ($currency == 'EUR') ? '&euro;' : '$'}}</td>
                </tr>
                @php
                    $totalWeight = 0.00;
                    $totalPrice = 0.00;
                @endphp
            @endforeach
            <tr style="background: none!important; font-size: 12px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: 600">Pristatymo kaina:</td>
                <td style="font-size: 14px">{{ number_format((float)$quote->delivery_price, 2, '.', '') }} {{ ($currency == 'EUR') ? '&euro;' : '$'}}</td>
            </tr>
            <tr style="background: none!important; font-size: 12px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: 600">Total:</td>
                <td style="font-size: 14px">{{ number_format((float)$finalPrice + $quote->delivery_price, 2, '.', '') }} {{ ($currency == 'EUR') ? '&euro;' : '$'}}</td>
            </tr>
            <tr style="background: none!important; font-size: 12px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: 600">PVM 21%:</td>
                <td style="font-size: 14px">{{ number_format($finalPrice*0.21, 2, '.', '') }} {{ ($currency == 'EUR') ? '&euro;' : '$'}}</td>
            </tr>
            <tr style="background: none!important; font-size: 12px">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td style="font-weight: 600">Viso su PVM:</td>
                <td style="font-size: 14px">{{ number_format($finalPrice + $finalPrice*0.21 + $quote->delivery_price, 2, '.', '') }} {{ ($currency == 'EUR') ? '&euro;' : '$'}}</td>
            </tr>
        </table>
        <style>
            .Something{
                position: absolute;
                bottom: 0;
            }
            .botz{
                font-size: 14px;
                border-collapse: collapse;
            }

        </style>
        <div class="Something">

            <br><hr style="background:#dedede; color:#dedede">
            <table class="botz" width="100%" style="font-size: 12px; text-align: left">
                <tr style="background: none!important;">
                    {{-- <td><b>Apmokėti iki:</b></td> --}}
                    <td style="border-left: none!important">
                        <?php //echo date('Y-m-d', strtotime($quote->created_at. ' +' .$quote->client->credit_amount. ' days')); ?>
                    </td>
                    <td><b>Kurjeris:</b></td>
                    <td style="border-left: none!important">{{ $quote->client->courier_account}}</td>
                    <td><b>Sąlygos:</b></td>
                    <td>{{ $quote->client->payment_term}}</td>
                </tr>
                {{-- <tr style="background: none!important">>
                    <td><b>Payment:</b></td>
                    <td style="border-left: none!important">T/T bank transfer</td>
                    <td><b>Packing:</b></td>
                    <td style="border-left: none!important">Original packing</td>
                </tr>
                <tr style="background: none!important">>
                    <td><b>Valid to:</b></td>
                    <td style="border-left: none!important">2018 04 21</td>
                </tr> --}}

            </table>
            <p style="font-size: 10px; text-align: center">Terms and conditions along with warranty info on www.powerpartspro.co.uk. All Manufacturers,Numbers,Simbols and Descriptions are used for Reference Purpose Only and it is not implied that any Part Listed is the Product of these Manufacturers</p>

    </body>
</html>
