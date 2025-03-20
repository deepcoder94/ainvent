<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use ZipArchive;


class GstInvoiceController extends Controller
{
    public function showGstInvoiceForm()
    {
        return view('pages.generate-gst.form', ['currentPage' => 'gstInvoice']);
    }
    public function generateGstInvoice(Request $request)
    {
        $currentDate = Carbon::now()->format('d-m-Y'); // Format the date as you want

        // Create a new ZIP file in storage
        $zipFileName = 'gst_invoice_'.$currentDate."_".time().'.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive();
        // Open the zip file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        $data = $request->all();

        $formattedDate = Carbon::createFromFormat('m/d/Y', $data['invoice_date'])->format('d-m-Y');
        $data['invoice_date'] = $formattedDate;


// Collect and transform product data into a new array
        $products = collect($data['product_description'])->map(function ($description, $index) use ($data) {
            return [
                'product_description'   => $description,
                'product_code'          => $data['product_code'][$index],
                'product_qty'           => $data['product_qty'][$index],
                'product_unit'          => $data['product_unit'][$index],
                'product_unit_price'    => $data['product_unit_price'][$index],
                'product_discount'      => $data['product_discount'][$index],
                'product_taxable_amt'   => $data['product_taxable_amt'][$index],
                'product_tax_rate'      => $data['product_tax_rate'][$index],
                'product_other_charges' => $data['product_other_charges'][$index],
                'product_total'         => $data['product_total'][$index],
            ];
        })->toArray();

// Replace the old product data with the new array and remove old keys
        $data = array_merge($data, ['products' => $products]);

// Optionally, remove the old product-related keys from the main array if you don't need them anymore
        unset($data['product_description']);
        unset($data['product_code']);
        unset($data['product_qty']);
        unset($data['product_unit']);
        unset($data['product_unit_price']);
        unset($data['product_discount']);
        unset($data['product_taxable_amt']);
        unset($data['product_tax_rate']);
        unset($data['product_other_charges']);
        unset($data['product_total']);

// Output the updated array with new 'products' field

        // $data = [
        //     'irn' => '359916310f02043428e4a6c9dd418cda67a08c',
        //     'ack_no' => '182518468020106',
        //     'ack_date' => '01-03-2025 13:08:00',
        //     'document_no' => '3059',
        //     'document_date' => '01-03-2025',
        //     'supplier' => [
        //         'name' => 'DEB ENTERPRISE',
        //         'gstin' => '19GDKPD1370P1Z1',
        //         'address' => '47/1, DR.C.C.C.ROAD, BHADRESWAR, HOOGHLY 712124, WEST BENGAL',
        //         'phone' => '9038477792',
        //     ],
        //     'recipient' => [
        //         'name' => 'UNIQUE ENTERPRISE',
        //         'gstin' => '19AOAPK0062L1Z0',
        //         'address' => '141/A, SAFUIPARA, BAIDYAPARA, KOLKATA 700078, WEST BENGAL',
        //     ],
        //     'items' => [
        //         [
        //             'sl_no' => 1,
        //             'description' => 'KG Mustard Oil 1 ltr Pch-Strong',
        //             'hsn_code' => '15149920',
        //             'quantity' => '4000 NOS',
        //             'unit_price' => '135.710',
        //             'taxable_amount' => '542856',
        //             'gst' => '5%',
        //             'total' => '569998.80',
        //         ],
        //     ],
        //     'summary' => [
        //         'taxable_amount' => '542856.00',
        //         'cgst' => '13571.40',
        //         'sgst' => '13571.40',
        //         'round_off' => '1.20',
        //         'total_invoice' => '570000.00',
        //     ],
        //     'generated_by' => '19GDKPD1370P1Z1',
        // ];

        $pdf = Pdf::loadView('pages.generate-gst.gst-format',$data);
        $pdf->setPaper('A4');
        $pdfContent = $pdf->output();
        // Add the PDF to the zip with a unique filename (e.g., invoice number)
        $zip->addFromString('gst_invoice_'.$currentDate.'.pdf', $pdfContent);        
        // Close the zip file
        $zip->close();

        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('downloadZip', ['file' => $zipFileName])
        ]);
    }
}
