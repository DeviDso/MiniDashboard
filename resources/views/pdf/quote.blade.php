<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Quote</title>
        {{-- <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet"> --}}
        <style>
        /* @import url('https://fonts.googleapis.com/css?family=Open+Sans'); */
            body{
                font-family: 'Open Sans', sans-serif;
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
                border-bottom: solid 1px #444;
            }
            table tr:nth-child(even){
                /* background: #f6f6f6; */
            }
            table.main{
                border: 0.9px solid #ddd;
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
            {{-- <br> --}}
            <p style="font-size: 14px; line-height: 19px">
                Power Parts Pro UAB Company ID 302784671 VAT TAX ID LT100006906012 Tel. 0037060884059<br>
                Registration adress: Ateities pl. 31, 52167, Kaunas Payments: Bank name - Swedbank AB<br>
                Account number IBAN: LT31 7300 0101 3188 2929 BIC / SWIFT – HABALT22<br>
            </p>
        </div>
        <table width="100%" style="font-size: 14px; text-align: center; margin-top: 10px" class="main">
            <tr>
                <td>Document type</td>
                <td>Proforma invoice</td>
                <td>Document No.</td>
                <td>Document date</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>{{ $quote->id }}</td>
                <td>{{ substr($quote->created_at, 0, 10) }}</td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 15px" class="main">
            <tr>
                <td style="width: 60%!important;font-size: 12px;">
                    <b>Customer:</b><br><br>
                    {{ $quote->client->name }}<br>
                    Tel.: {{ $quote->client->phone}} <br>
                    Email: {{ $quote->client->email }} <br><br>
                    {{-- Address:<br>
                    {{ $quote->client->street . ' ' . $quote->client->post_code . ', ' . $quote->client->city . ', ' . $quote->client->country }} <br> --}}

                </td>
                <td style="font-size: 12px; border-left: solid 1px #ddd">
                    <b>Delivery to:</b><br><br>
                    {{ $quote->client->name }}<br>
                    {{ $quote->client->street . ' ' . $quote->client->post_code . ', ' . $quote->client->city . ', ' . $quote->client->country }} <br>
                    &nbsp;
                </td>
            </tr>
        </table>
        {{-- <div class="center" style="margin-top: 45px; margin-bottom: 45px">
            <h3>QUATATION No. {{ $quote->id }}</h3><br>
            Date: {{ substr($quote->created_at, 0, 10) }}
        </div> --}}
        <table width="100%" style="font-size: 14px; margin-top: 25px">
            <tr style="font-weight: 800">
                <th>Part no.</th>
                <th>Description</th>

                <th>Quantity</th>
                {{-- <th>Delivery</th> --}}

                <th>Unit weight</th>
                <th>Total weight</th>
                <th>Price</th>
                <th>Total price</th>
            </tr>
            @foreach($quote->data as $index => $d)
                @php
                    $totalWeight = $totalWeight + $d->bruto;
                    $totalPrice = $totalPrice + $d->price;
                    $netWeight = $netWeight + $d->netto;
                    $finalPrice = $finalPrice + $d->price;
                @endphp
                <tr>
                    {{-- <td>{{ $index+1 }}.</td> --}}
                    <td>{{ $d->code }}</td>§
                    <td>{{ $d->name }}</td>

                    <td>{{ $d->quantity }}</td>
                    {{-- <td>{{ ($d->product_id) ? 'In stock' : 'Not available' }}</td> --}}

                    <td>{{ ($d->bruto != '') ? $d->bruto : '-' }}</td>
                    {{-- <td>{{ ($d->netto != '') ? $d->netto : '-' }}</td> --}}
                    <td>{{ sprintf('%0.2f', $totalWeight) }}</td>
                    <td>{{ $d->price }} &euro;</td>
                    <td>{{ sprintf('%0.2f', $totalPrice * $d->quantity) }} &euro;</td>
                </tr>
                @php
                    $totalWeight = 0.00;
                    $totalPrice = 0.00;
                @endphp
            @endforeach
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
            <table class="botz" width="100%">
                <tr>
                    <td width="13%"><b>Terms:</b></td>
                    <td width="47%" style="border-left: none!important">100% advance payment</td>
                    <td width="20%"><b>Carrier:</b></td>
                    <td width="15%" style="border-left: none!important">-</td>
                </tr>
                <tr>
                    <td><b>Payment:</b></td>
                    <td style="border-left: none!important">T/T bank transfer</td>
                    <td><b>Packing:</b></td>
                    <td style="border-left: none!important">Original packing</td>
                </tr>
                <tr>
                    <td><b>Valid to:</b></td>
                    <td style="border-left: none!important">2018 04 21</td>
                    <td><b>Total amount</b></td>
                    <td style="font-size: 16px; font-weight: 800">{{ number_format((float)$finalPrice, 2, '.', '') }} &euro;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><b>Total incl. 21% tax</b></td>
                    <td style="font-size: 16px; font-weight: 800">{{ number_format((float)$finalPrice + $finalPrice*0.21, 2, '.', '') }} &euro;</td>
                </tr>
            </table>
            <p style="font-size: 12px; text-align: center">Terms and conditions along with warranty info on www.powerpartspro.co.uk. All Manufacturers,Numbers,Simbols and Descriptions are used for Reference Purpose Only and it is not implied that any Part Listed is the Product of these Manufacturers</p>

        </div>

        {{-- <div class="full" style="position: absolute; bottom: 0">
            </div> --}}
        {{-- <div class="full" style="position: absolute; bottom: 0">
            <b style="text-decoration: underline">If the amount of the goods shipped is less than 100 &euro;, we will charge you 20 &euro; extra</b>
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
            <p>Terms and conditions along with warranty info on www.powerpartspro.co.uk. All Manufacturers,Numbers,Simbols and Descriptions are used for Reference Purpose Only and it is not implied that any Part Listed is the Product of these Manufacturers</p>
        </div> --}}
    </body>
</html>
