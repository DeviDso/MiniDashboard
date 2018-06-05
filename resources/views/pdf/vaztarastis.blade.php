<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Važtaraštis</title>
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
                /* background: #f6f6f6; */
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
            <h2>Važtaraštis</h2>
            <h5>Nr. {{ $order->id }}</h5>
            <h6 style="margin-top: -15px">{{ date('Y-m-d') }}</h6>
        </div>
        <div id="top_table">
            <table width="100%" class="main" style="font-size: 11px">
                <tr>
                    <td style="width: 20%"><b>Pakrovimo vieta</b></td>
                    <td>{{ $vaztarastis['pakrovimo_vieta'] }}</td>
                </tr>
                <tr>
                    <td><b>Iškrovimo vieta</b></td>
                    <td>{{ $vaztarastis['iskrovimo_vieta'] }}</td>
                </tr>
            </table>
            <table width="100%" class="main">
                <tr>
                    <td style="width: 33%!important;font-size: 11px;">
                        <h3>Siuntėjas</h3>
                        Power Parts Pro UAB</b><br>
                        Ateities pl. 31, 52167, Kaunas
                    </td>
                    <td style="font-size: 11px">
                        <h3>Vežėjas</h3>
                        {{ $vaztarastis['vezejo_pavadinimas'] }}<br>
                        {{ $vaztarastis['vezejo_adresas'] }}
                    </td>
                    <td style="font-size: 11px">
                        <h3>Gavėjas</h3>
                        {{ $order->client->name }}<br>
                        {{ $order->client->street . ' ' . $order->client->post_code . ', ' . $order->client->city . ', ' . $order->client->country }}
                    </td>
                </tr>
            </table>
        </div>
        <h4>Krovinys</h4>
        <table width="100%" style="font-size: 12px; margin-top: 15px">
            <tr style="color: #000!important">
                <th style="font-weight: 600">Detalės nr.</th>
                <th style="font-weight: 600">Aprašymas</th>
                <th style="font-weight: 600">Kiekis</th>
                <th style="font-weight: 600">Vnt. svoris</th>
                <th style="font-weight: 600">Viso svoris</th>
            </tr>
            @foreach($order->data as $index => $d)
                @php
                    $totalWeight = $totalWeight + $d->bruto;
                    $netWeight = $netWeight + $d->netto;
                @endphp
                <tr>
                    <td>{{ $d->code }}</td>§
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->quantity }} vnt.</td>
                    <td>{{ ($d->bruto != '') ? $d->bruto : '-' }} kg</td>
                    <td>{{ sprintf('%0.2f', $totalWeight) }} kg</td>
                </tr>
                @php
                    $totalWeight = 0.00;
                @endphp
            @endforeach
        </table>
        <h4 style="margin-top: 45px">Transporto priemonės</h4>
        <table width="100%" style="font-size: 12px; margin-top: 15px">
            <tr style="color: #000!important; font-weight: 600">
                <td>Reg. nr</td>
                <td>Markė, modelis</td>
                <td>Plombos ID</td>
                <td>Plombos aprašymas</td>
            </tr>
            <tr>
                <td>{{ $vaztarastis['transporto_nr'] }}</td>
                <td>{{ $vaztarastis['transporto_modelis'] }}</td>
                <td></td>
                <td></td>
            </tr>
        </table>
    </body>
</html>
