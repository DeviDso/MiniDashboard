<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Order;

class PDFController extends Controller
{
    public function generate(Request $r){
        $data['quote'] = Order::with(['data', 'client'])->findOrFail($r->input('quote_id'));

        $pdf = PDF::loadView('pdf.quote', $data);
        // $pdf->setOption('javascript-delay', 3000);
        return $pdf->stream('invoice.pdf');
    }
}
