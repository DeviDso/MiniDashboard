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

        $date = Date('Y-m-d');
        $date = str_replace('-', '', $date);

        $data['unique'] = 'Order ' . $date. '/0' . $data['quote']->id;

        $pdf = PDF::loadView('pdf.order', $data);

        return $pdf->stream($data['unique'] . '.pdf');
    }

    public function generateOrderLT(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $date = Date('Y-m-d');
        $date = str_replace('-', '', $date);

        $data['unique'] = 'Užsakymas ' . $date. '/0' . $data['quote']->id;

        $pdf = PDF::loadView('pdf.order-lithuanian', $data);

        return $pdf->stream($data['unique'] . '.pdf');
    }

    public function generatePreInvoiceEN(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $date = Date('Y');
        $date = substr($date, -2);

        $data['unique'] = 'Proforma invoice #PPP-PI-' . $date. '-000' . $data['quote']->id;

        $pdf = PDF::loadView('pdf.pre-invoice', $data);

        return $pdf->stream($data['unique'] . '.pdf');
    }

    public function generatePreInvoiceLT(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $date = Date('Y');
        $date = substr($date, -2);

        $data['unique'] = 'Išankstinė sąskaita #PPP-PI-' . $date. '-000' . $data['quote']->id;

        $pdf = PDF::loadView('pdf.pre-invoice-lithuanian', $data);

        return $pdf->stream($data['unique'] . '.pdf');
    }

    public function generateInvoiceLT(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $date = Date('Y');
        $date = substr($date, -2);

        $data['unique'] = 'PVM sąskaita faktūra #PPP-' . $date. '-000' . $data['quote']->id;

        $pdf = PDF::loadView('pdf.pre-invoice-lithuanian', $data);

        return $pdf->stream($data['unique'] . '.pdf');
    }

    public function generateInvoiceEn(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));
        $data['currency'] = $r->input('currency');

        $date = Date('Y');
        $date = substr($date, -2);

        $data['unique'] = 'Invoice #PPP-' . $date. '-000' . $data['quote']->id;

        $pdf = PDF::loadView('pdf.invoice', $data);

        return $pdf->stream($data['unique'] . '.pdf');
    }


    public function vaztarastis(Request $r){
        $data['order'] = Order::with(['data', 'client'])->findOrFail($r->input('order_id'));
        $data['vaztarastis'] = $r->all();

        $pdf = PDF::loadView('pdf.vaztarastis', $data);

        return $pdf->stream('vaztarastis-.pdf');
    }
}
