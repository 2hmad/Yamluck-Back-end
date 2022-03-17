<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;
use PDF;

class CreateInvoiceController extends Controller
{
    public function index($id)
    {
        $getInvoice = Payments::where('invoice_id', $id)->first();
        if ($getInvoice == null) {
            return response()->json(['alert' => 'Permission Denied'], 404);
        } else {
            $file = view('invoice', compact('getInvoice'))->render();
            return $file;
            // $pdf = PDF::loadView('invoice', compact('getInvoice'));
            // return $pdf->download('invoice.pdf');
        }
    }
}
