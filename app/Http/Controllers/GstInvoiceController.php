<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Product;
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
                'gst_rate'              => $data['gst_rate'][$index],
                'cess_rate'             => $data['cess_rate'][$index],
                'state_cess_rate'       => $data['state_cess_rate'][$index],
                'non_advol_rate'        => $data['non_advol_rate'][$index],

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
        unset($data['gst_rate']);
        unset($data['cess_rate']);
        unset($data['state_cess_rate']);
        unset($data['non_advol_rate']);

        unset($data['product_other_charges']);
        unset($data['product_total']);
        
        foreach($data['products'] as $p){
            $prod = Product::where('product_name',$p['product_description'])->get()->first();
            $inv = Inventory::where('product_id',$prod->id)->get()->first();
            $leftStock = $inv->total_stock - $p['product_qty'];
            $inv->total_stock = $leftStock;
            $inv->save();

            InventoryHistory::create([
                'product_id' => $prod->id,
                'measurement_id' => 1,
                'stock_out_in'   => $p['product_qty'],
                'stock_action'  => 'deduct',
                'buying_price'  => 0
            ]);
        }

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
