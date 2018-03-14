<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Quote</title>
        <style>
            .center{
                text-align: center
            }
            .full{
                width: 100%;
                float: left;
            }
            .half{
                width: 50%;
                float: left;
            }
            table tr th{
                font-weight: 400;
                background: #333;
                color: white;
                /* border-bottom: solid 1px #444; */
            }
            table tr:nth-child(even){
                background: #f6f6f6;
            }
            table{
                border: 0.9px solid #ddd;
            }
            .bottom-table{
                width: 100%;
                font-size: 13px;
                margin-top: 3px;
            }
            .bottom-table tr td{
                border-left: solid 1px #ddd;
            }
        </style>

        </head>
    @php
        $totalWeight = 0.00;
        $totalPrice = 0.00;
        $netWeight = 0.00;
    @endphp
    <body>
        <div style="text-align: right">
            <img src="https://www.powerpartspro.com/template/img/logo.png">
        </div>
        <table width="100%">
            <tr>
                <td style="width: 50%!important;font-size: 12px;">
                    <b>Power Parts Pro UAB</b><br>
                    Ateities pl. 31, 52167 Kaunas, Lithuania <br>
                    Tel.: +370 67700 900 <br>
                    info@powerpartspro.co.uk<br>
                    VAT Tax ID LT100006906012 Co. ID 302784671<br>
                    Bank: Swedbank AB, Address: Konstitucijos pr 20a, Vilnius<br>
                    IBAN: LT317300010131882929 SWIFT: HABALT22<br>
                    Bank code: 73000, Beneficiary: Power Parts Pro
                </td>
                <td style="font-size: 12px; border-left: solid 1px #ddd">
                    <b>{{ $quote->client->name }}</b><br>
                    {{ $quote->client->street . ' ' . $quote->client->post_code . ', ' . $quote->client->city . ', ' . $quote->client->country }} <br>
                    Tel.: {{ $quote->client->phone}} <br>
                    {{ $quote->client->email }}
                </td>
            </tr>
        </table>
        <div class="center" style="margin-top: 45px; margin-bottom: 45px">
            <h3>QUATATION No. {{ $quote->id }}</h3><br>
            Date: {{ substr($quote->created_at, 0, 10) }}
        </div>
        <table width="100%" style="font-size: 14px">
            <tr style="font-weight: 800">
                <th>#</th>
                <th>Part name</th>
                <th>Part number</th>
                <th>Quantity</th>
                <th>Delivery</th>
                <th>Amount Eur</th>
                <th>Bruto (Kg)</th>
                <th>Netto (Kg)</th>
            </tr>
            @foreach($quote->data as $index => $d)
                @php
                    $totalWeight = $totalWeight + $d->bruto;
                    $totalPrice = $totalPrice + $d->price;
                    $netWeight = $netWeight + $d->netto;
                @endphp
                <tr>
                    <td>{{ $index+1 }}.</td>
                    <td>{{ $d->name }}</td>
                    <td>{{ $d->code }}</td>
                    <td>{{ $d->quantity }}</td>
                    <td>{{ ($d->product_id) ? 'In stock' : 'Not available' }}</td>
                    <td>{{ $d->price }}</td>
                    <td>{{ ($d->bruto != '') ? $d->bruto : '-' }}</td>
                    <td>{{ ($d->netto != '') ? $d->netto : '-' }}</td>
                </tr>
            @endforeach
        </table>
        <div class="full" style="position: absolute; bottom: 0">
            {{-- <b style="text-decoration: underline">If the amount of the goods shipped is less than 100 &euro;, we will charge you 20 &euro; extra</b> --}}
            <table class="bottom-table">
                <tr>
                    <td width="25%">Net price:</td>
                    <td width="25%">Terms:</td>
                    <td width="25%">Delivery as reported unless sold</td>
                    <td width="25%">Validity 30 days</td>
                </tr>
            </table>
            <table class="bottom-table">
                <tr>
                    <td width="100%">Payment: At order confirmation</td>
                </tr>
            </table>
            <table class="bottom-table">
                <tr>
                    <td width="25%">Net weight: {{ $netWeight }}</td>
                    <td width="25%">Total weight: {{ $totalWeight }}</td>
                    <td width="25%">Transport cost: <b>{{ $quote->delivery_price }} &euro;</td>
                    <td width="25%">Handling & packing cost:</td>
                </tr>
            </table>
            <table class="bottom-table">
                <tr>
                    <td width="25%">Goods amount: <b>{{ number_format((float)$totalPrice, 2, '.', '') }} &euro;</b></td>
                    <td width="25%">Amount: <b>{{ number_format((float)$totalPrice, 2, '.', '') }} &euro;</b></td>
                    <td width="25%">-</td>
                    <td width="25%">Total: <b>{{ number_format((float)$totalPrice+$quote->delivery_price, 2, '.', '') }} &euro;</b></td>
                </tr>
            </table>
        </div>
    </body>
</html>
