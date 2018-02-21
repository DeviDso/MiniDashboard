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
        </style>
    </head>
    <body>
        <div class="center">
            <h1>Quote</h1>
        </div>
        <table style="width: 100%">
            <tr>
                <td>Client</td>
                <td>PP</td>
            </tr>
            <tr>
                <td></td>
            </tr>
        </table>
        <hr>
        <table width="100%">
            <tr style="font-weight: 800">
                <td>#</td>
                <td>Part number</td>
                <td>Quantity</td>
                <td>Amount Eur</td>
            </tr>
            @foreach($quote->data as $index => $d)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $d->code }}</td>
                    <td>{{ $d->quantity }}</td>
                    <td>{{ $d->price }}</td>
                </tr>
            @endforeach
        </table>
    </body>
</html>
