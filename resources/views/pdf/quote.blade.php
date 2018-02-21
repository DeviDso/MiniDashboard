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
        </style>
    </head>
    @php
        $totalWeight = 1.00;
    @endphp
    <body>
        <div class="center">
            <h1>{{ $quote->client->name }}</h1>
            <h2>Quote</h2>
            <hr>
        </div>
        <div class="center" style="margin-top: 25px; margin-bottom: 45px">
            {{ $quote->note }}
        </div>
        <table width="100%">
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
        <div class="full" style="margin-top: 55px;">
            Delivery price: <b>{{ $quote->delivery_price }} &euro;</b><br>
            Total weight: <b>{{ number_format((float)$totalWeight, 2, '.', '') }} kg</b>
        </div>
    </body>
</html>
