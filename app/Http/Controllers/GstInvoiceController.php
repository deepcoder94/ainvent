<?php
namespace App\Http\Controllers;

use App\Models\GstInvoice;
use App\Models\GstInvoiceProduct;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\InvoiceProfit;
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
                'product_min_rate'      => $data['product_min_rate'][$index],
                'product_discount'      => $data['product_discount'][$index],
                'product_taxable_amt'   => $data['product_taxable_amt'][$index],
                'gst_rate'              => $data['product_gst_rate'][$index],
                'cess_rate'             => $data['product_cess_rate'][$index],
                'state_cess_rate'       => $data['product_state_cess_rate'][$index],
                'non_advol_rate'        => $data['product_non_advol_rate'][$index],

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
        unset($data['product_min_rate']);
        unset($data['product_discount']);
        unset($data['product_taxable_amt']);
        unset($data['product_gst_rate']);
        unset($data['product_cess_rate']);
        unset($data['product_state_cess_rate']);
        unset($data['product_non_advol_rate']);

        unset($data['product_other_charges']);
        unset($data['product_total']);
        
        $lastRec = GstInvoice::create([
            'supplier_details'=>json_encode([
                'supplier_name'=>$data['supplier_name'],
                'supplier_gstin'=>$data['supplier_gstin'],
                'supplier_address'=>$data['supplier_address'],
                'supplier_phone'=>$data['supplier_phone']
                ]
            ),
            'receipent_details'=>json_encode([
                'recepent_name'=>$data['recepent_name'],
                'recepent_gstin'=>$data['recepent_gstin'],
                'recepent_address'=>$data['recepent_address'],
                'recepent_phone'=>$data['recepent_phone']
            ]),
            'invoice_number'=>$data['invoice_no'],
            'invoice_date'=>$data['invoice_date'],
            'gst_breakup'=>json_encode([
                'gst_cgst'=>$data['gst_cgst'],
                'gst_sgst'=>$data['gst_sgst'],
                'gst_igst'=>$data['gst_igst'],
                'gst_cess'=>$data['gst_cess'],
                'gst_state_cess'=>$data['gst_state_cess']
            ]),
            'taxable_amount'=>$data['gst_taxable_amt'],
            'discount'=>$data['gst_discount'],
            'other_charges'=>$data['gst_other_charges'],
            'round_off_amount'=>$data['gst_roundoff'],
            'total_invoice_amount'=>$data['gst_total_inv']
        ]);

        $profit = 0;

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

            // Profit
            // SP-CP * quantity
            $sp = $p['product_unit_price'];
            $cp = $p['product_min_rate'];
            $profit += ($sp-$cp) * $p['product_qty'];

            GstInvoiceProduct::create([
                'gst_invoice_id'=>$lastRec->id,
                'product_name'=>$p['product_description'],
                'hsn_code'=>$p['product_code'],
                'quantity'=>$p['product_qty'],
                'unit_price'=>$p['product_unit_price'],
                'taxable_amount'=>$p['product_taxable_amt'],
                'gst_breakup'=>json_encode([
                    'gst_rate'=>$p['gst_rate'],
                    'cess_rate'=>$p['cess_rate'],
                    'state_cess_rate'=>$p['state_cess_rate'],
                    'non_advol_rate'=>$p['non_advol_rate']
                ]),
                'other_charges'=>$p['product_other_charges'],
                'total'=>$p['product_total']
            ]);
            
        }

        InvoiceProfit::create([
            'invoice_number'=>$data['invoice_no'],
            'invoice_id'=>0,
            'gst_invoice_id'=>$lastRec->id,
            'is_gst_invoice'=>1,
            'profit_amount'=>$profit
        ]);

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

    public function addGstInvoiceFormProduct(Request $request,$id){
        $products = Product::get();
        return view('pages.generate-gst.add-single-product',compact('products','id'));
    }

    public function list(Request $request){
        $currentPage = 'gstInvoiceList';
        $gst_invoices = GstInvoice::with('gst_invoice_products')->get()->toArray();
        foreach($gst_invoices as $index => $i){
            $gst_invoices[$index]['supplier_details'] = json_decode($i['supplier_details'],true);
            $gst_invoices[$index]['receipent_details'] = json_decode($i['receipent_details'],true);
            $gst_invoices[$index]['gst_breakup'] = json_decode($i['gst_breakup'],true);

        }
        return view('pages.gst-invoices.list',compact('currentPage','gst_invoices'));
    }

    public function getMaxQtyByTypeAndProductName(Request $request,$typeId,$productName){
        $products    = Product::with('measurements')->with('inventory')->where('product_name',$productName)->get()->first();        

        $total_stock = $products->inventory->total_stock;
        $buying_price = $products->inventory->buying_price; // Min rate

        $measurement = $products->measurements;
        $qty = collect($measurement)->filter(function($value) use ($typeId){
            return $value->id == $typeId;
        })->first()->quantity;

        return response()->json(
            [
                'max_qty'=>number_format(($total_stock/$qty),2),
                'min_rate'=>$buying_price
            ]
        );        
    }
}
