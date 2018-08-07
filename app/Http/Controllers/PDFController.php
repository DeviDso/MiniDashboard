<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Order;

class PDFController extends Controller
{
    public function generateEN(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $pdf = PDF::loadView('pdf.quote', $data);

        return $pdf->stream('Quotation #' . $data['quote']->id . '.pdf');
    }

    public function generateLT(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $pdf = PDF::loadView('pdf.quote-lithuanian', $data);

        $random = rand(1000, 9999);

        return $pdf->stream('Pasiūlymas #' . $data['quote']->id . '.pdf');
    }

    public function generateOrderEN(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $pdf = PDF::loadView('pdf.order', $data);

        return $pdf->stream('Order #' . $data['quote']->id . '.pdf');
    }

    public function generateOrderLT(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $pdf = PDF::loadView('pdf.order-lithuanian', $data);

        return $pdf->stream('Užsakymas #' . $data['quote']->id . '.pdf');
    }

    public function vaztarastis(Request $r){
        $data['order'] = Order::with(['data', 'client'])->findOrFail($r->input('order_id'));
        $data['vaztarastis'] = $r->all();

        $pdf = PDF::loadView('pdf.vaztarastis', $data);

        return $pdf->stream('vaztarastis-.pdf');
    }
}
