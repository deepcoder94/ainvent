<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

class GstInvoiceController extends Controller
{
    public function showGstInvoiceForm(){    
        return view('pages.generate-gst.form',['currentPage'=>'gstInvoice']);
    }
    public function generateGstInvoice(){
        $data = [
            'irn' => '359916310f02043428e4a6c9dd418cda67a08c',
            'ack_no' => '182518468020106',
            'ack_date' => '01-03-2025 13:08:00',
            'document_no' => '3059',
            'document_date' => '01-03-2025',
            'supplier' => [
                'name' => 'DEB ENTERPRISE',
                'gstin' => '19GDKPD1370P1Z1',
                'address' => '47/1, DR.C.C.C.ROAD, BHADRESWAR, HOOGHLY 712124, WEST BENGAL',
                'phone' => '9038477792',
            ],
            'recipient' => [
                'name' => 'UNIQUE ENTERPRISE',
                'gstin' => '19AOAPK0062L1Z0',
                'address' => '141/A, SAFUIPARA, BAIDYAPARA, KOLKATA 700078, WEST BENGAL',
            ],
            'items' => [
                [
                    'sl_no' => 1,
                    'description' => 'KG Mustard Oil 1 ltr Pch-Strong',
                    'hsn_code' => '15149920',
                    'quantity' => '4000 NOS',
                    'unit_price' => '135.710',
                    'taxable_amount' => '542856',
                    'gst' => '5%',
                    'total' => '569998.80',
                ],
            ],
            'summary' => [
                'taxable_amount' => '542856.00',
                'cgst' => '13571.40',
                'sgst' => '13571.40',
                'round_off' => '1.20',
                'total_invoice' => '570000.00',
            ],
            'generated_by' => '19GDKPD1370P1Z1',
        ];
    
        $pdf = Pdf::loadView('pages.generate-gst.gst-format', $data);
        $pdf->setPaper('A4');

        return $pdf->download('invoice.pdf'); // Change to `stream()` if you want to preview it            
    }
}