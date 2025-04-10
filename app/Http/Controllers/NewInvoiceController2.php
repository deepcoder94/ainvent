<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Distributor;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;

use App\Models\Measurement;
use App\Models\Product;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use App\Models\InventoryHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class NewInvoiceController2 extends Controller
{
    public function index()
    {
        $customers   = Customer::get();
        $beats       = Beat::get();
        $products    = Product::with('measurements')->with('inventory')->get();
        $measurement = Measurement::get();
        return view('pages.generate-invoice-new.generate', ['currentPage' => 'invoiceGenerateNew', 'beats' => $beats, 'customers' => $customers, 'products' => $products, 'measurements' => $measurement]);
    }

    public function list()
    {
        $customers = Customer::get();
        $beats = Beat::get();

        $pages = Invoice::selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'desc')
        ->get();

        $firstPage = $pages[0]['date'];

        $invoices = Invoice::with('customer')->with('beat')->whereDate('created_at',$firstPage)->orderBy('id','desc')->get();
        return view('pages.invoices.list', ['currentPage' => 'invoicesList', 'invoices' => $invoices,'customers'=>$customers,'beats'=>$beats,'pages'=>$pages]);
    }

    public function loadPdfNew(Request $request)
    {
        $invoices = $request->input('selectedInvoices');
        $currentDate = Carbon::now()->format('d-m-Y'); // Format the date as you want
        // Create a new ZIP file in storage
        $zipFileName = 'invoices.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive();

        // Open the zip file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        $finalArray = [];

        foreach ($invoices as $i) {
            // Fetch invoice data
            $invoice = Invoice::with('customer')->with('beat')->find($i);
            $products = InvoiceProduct::where('invoice_id', $i)->with('product')->with('measurement')->get();
            $items = [];
            $boxtotal = 0;
            $pcstotal = 0;
            $totalnetamt = 0;
            $totalgst = 0;
            $taxableamt = 0;

            // dd($products);
            foreach ($products as $p) {
                $item = [
                    'qty' => $p->quantity,
                    'type' => $p->measurement->name,
                    'product_description' => $p->product->product_name,
                    'rate' => $p->rate,
                    'amount' => $p->quantity * $p->rate * $p->measurement->quantity,
                    'product_hsn'=>$p->product->product_hsn,
                    'box'=>$p->measurement->name!='Piece'?$p->quantity:0,
                    'pcs'=>$p->measurement->name=='Piece'?$p->quantity:0,
                    'gst_rate'=>$p->product->gst_rate,
                    'gst_amt'=>($p->product->gst_rate/100)*($p->rate * $p->measurement->quantity * $p->quantity),
                    'net_amt'=>(($p->product->gst_rate/100)*($p->rate * $p->measurement->quantity * $p->quantity))+ ($p->rate * $p->measurement->quantity * $p->quantity)
                ];
                $boxtotal += $p->measurement->name!='Piece'?$p->quantity:0;
                $pcstotal += $p->measurement->name=='Piece'?$p->quantity:0;
                $taxableamt += $p->rate * $p->measurement->quantity * $p->quantity;
                
                $totalnetamt += (($p->product->gst_rate/100)*($p->rate * $p->measurement->quantity * $p->quantity))+ ($p->rate * $p->measurement->quantity * $p->quantity);
                $totalgst += ($p->product->gst_rate/100)*($p->rate * $p->measurement->quantity * $p->quantity);
                array_push($items, $item);
            }



            $total = collect($items)->sum('amount');
            $grandTotal = $total;
            $customer = $invoice->customer;
            $invoice_number = 'INV-' . $invoice->id;
            $date = \Carbon\Carbon::parse($invoice->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s');
            $beat_name = $invoice->beat->beat_name;
            $distributor = Distributor::get()->first();


            $data = compact('items', 'total', 'grandTotal', 'customer', 'invoice_number', 'date', 'beat_name', 'distributor','boxtotal','pcstotal','totalnetamt','totalgst','taxableamt');
            $finalArray[] = $data;
        }
        $invoicesArray = ['invoices'=>$finalArray];
        // dd($invoicesArray);

            // Generate the PDF for the current invoice
            $pdf = PDF::loadView('pages.invoices.new-invoice-pdf', $invoicesArray);
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Add the PDF to the zip with a unique filename (e.g., invoice number)
            $zip->addFromString('invoices.pdf', $pdfContent);


        // Close the zip file
        $zip->close();

        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('downloadZip', ['file' => $zipFileName])
        ]);
    }

    public function downloadZip($file)
    {
        $path = storage_path('app/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }

    public function create(Request $request)
    {
        try {
            $products = collect($request->input('products'));
            $newInvoice = Invoice::create([
                'customer_id' => $request->input('customer_id'),
                'beat_id' => $request->input('beat_id')
            ]);

            $invoiceNumber = 'INV-'.$newInvoice->id;
            $newInvoice->invoice_number = $invoiceNumber;
            $newInvoice->save();
            $total = 0;

            $profit = 0;

            foreach ($products as $product) {

                $measurement = Measurement::where('id',$product['measurement_id'])->get()->first();

                // Profit = SP-CP * qty
                $sp = $product['rate'];
                $cp = $product['minrate'];
                $pqty = $product['qty'];
                $profit += ($sp-$cp)*$pqty;

                $pd = Product::where('id',$product['product_id'])->get()->first();


                $data = [
                    'invoice_id' => $newInvoice->id,
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'quantity' => $product['qty'],
                    'rate' => $product['rate'],
                    'buying_price'=>$cp,
                    'gst_rate'=>$pd->gst_rate
                ];


                InvoiceProduct::create($data);
                
                $inventory = Inventory::where('product_id', $product['product_id'])->get()->first();
                $totalDeduction = $measurement->quantity * $product['qty'];

                $rateded = $totalDeduction * $product['rate'];

                $t = (($pd->gst_rate/100)*$rateded) + $rateded; 


                $total += $t;




                $inventory->total_stock -= $totalDeduction;
                $inventory->save();

                InventoryHistory::create([
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'stock_out_in'   => $totalDeduction,
                    'stock_action'  => 'deduct'
                ]);

            }
            
            // InvoiceProfit::create([
            //     'invoice_number'=>$newInvoice->invoice_number,
            //     'invoice_id'=>$newInvoice->id,
            //     'gst_invoice_id'=>0,
            //     'is_gst_invoice'=>0,
            //     'profit_amount'=>$profit
            // ]);



                CustomerPayment::create([
                    'customer_id'=>$request->input('customer_id'),
                    'invoice_total'=>$total,
                    'total_due'=>$total,
                    'invoice_id'=>$newInvoice->id
                ]);

                $newInvoice->invoice_total = $total;
                $newInvoice->invoice_amount = $total;
                $newInvoice->save();

            $success = true;
            $message = 'Invoice saved successfully';
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function createShipment(Request $request) {
        $invoices = $request->input('selectedInvoices');
        foreach ($invoices as $i){
            $products = InvoiceProduct::where('invoice_id',$i)->with('product')->with('measurement')->get();

            $items = [];
            foreach ($products as $p) {
                $item = [
                    'qty' => $p->quantity,
                    'type' => $p->measurement->name,
                    'product_description' => $p->product->product_name,
                    'rate' => $p->product->product_rate,
                    'amount' => $p->quantity * $p->product->product_rate
                ];
                array_push($items, $item);
            }
            $total = collect($items)->sum('amount');
            $grandTotal = $total;            
        }
    }

    public function searchInvoice(Request $request){
        $invId =$request->input('invId');
        $invDate =$request->input('invDate');
        $invCustomer =$request->input('invCustomer');
        $invBeat =$request->input('invBeat');
        $invDate2 =$request->input('invDate2');


        $query = Invoice::query();
        if(!empty($invDate)){
            $formattedDate = Carbon::createFromFormat('m/d/Y', $invDate)->format('Y-m-d');
            $query->whereDate('created_at',$formattedDate);
        }
        if(!empty($invDate2)){
            $query->whereDate('created_at',$invDate2);
        }        
        if(!empty($invId)){
            $query->where('invoice_number',$invId);
        }
        if(!empty($invCustomer)){
            $query->where('customer_id',(int)$invCustomer);
        }
        if(!empty($invBeat)){
            $query->where('beat_id',(int)$invBeat);
        }        
        $records = $query->orderBy('id','desc')->get();
        return view('pages.invoices.list-single',['invoices'=>$records]);

    }

    public function loadSingleProduct(Request $request,$id){
        $products    = Product::with('measurements')->with('inventory')->get();
        $filteredProds = [];
        foreach($products as $p){
            if(empty($p->inventory) || $p->total_stock > 0){
                continue;
            }
            array_push($filteredProds,$p);
        }
        $measurement = Measurement::get();
        return view('pages.generate-invoice.generate-product-single',compact('filteredProds','measurement','id'));
    }

    public function invoiceView(Request $request,$id){
        $invoice = Invoice::with('customer')->with('beat')->find($id);
        $products = InvoiceProduct::where('invoice_id', $id)->with('product')->with('measurement')->get();

        $items = [];
        foreach ($products as $p) {
            $item = [
                'qty' => $p->quantity,
                'type' => $p->measurement->name,
                'product_description' => $p->product->product_name,
                'rate' => $p->rate,
                'amount' => $p->quantity * $p->rate * $p->measurement->quantity
            ];
            array_push($items, $item);
        }

        $total = collect($items)->sum('amount');
        $grandTotal = $total;
        $customer = $invoice->customer;
        $invoice_number = 'INV-' . $invoice->id;
        $date = \Carbon\Carbon::parse($invoice->created_at)->timezone('Asia/Kolkata')->format('d-m-Y H:i:s');
        $beat_name = $invoice->beat->beat_name;
        $distributor = Distributor::get()->first();


        $data = compact('items', 'total', 'grandTotal', 'customer', 'invoice_number', 'date', 'beat_name', 'distributor');
        $finalArray[] = $data;

        $invoicesArray = ['invoices'=>$finalArray];
        return view('pages.invoices.invoice-pdf',$invoicesArray);

    }

    public function getCustomersByBeat(Request $request,$id){
        $customers   = Customer::where('beat_id',$id)->get();
        return response()->json([
            'customers'=>$customers
        ]);
    }

    public function getMeasurementsByProduct(Request $request,$id){
        $products    = Product::with('measurements')->with('inventory')->where('id',$id)->get()->first();

        return response()->json([
            'data'=>$products->measurements
        ]);
    }

    public function getMaxQtyByTypeAndProduct(Request $req,$typeId,$productId){
        $products    = Product::with('measurements')->with('inventory')->where('id',$productId)->get()->first();        

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
