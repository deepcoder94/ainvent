<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Product;

use App\Models\Beat;
use App\Models\Customer;
use App\Models\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceProduct;

use App\Models\Inventory;
use App\Models\InventoryHistory;

use App\Models\InvoiceRequestProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerPayment;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use App\Models\Distributor;

class InvoiceRequestController extends Controller
{
    public function list(){
        $customers = Customer::get();
        $beats = Beat::get();

        $pages = InvoiceRequest::selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'desc')
        ->get();
        if(count($pages)>0){
            $firstPage = $pages[0]['date'];
            $invoices = InvoiceRequest::with('customer')->with('beat')->with('products')->whereDate('created_at',$firstPage)->orderBy('id','desc')->get();            
        }
        else{
            $invoices=[];
        }
        

        return view('pages.invoice-requests.list.layout', ['currentPage' => 'invoiceRequestList', 'invoices' => $invoices,'customers'=>$customers,'beats'=>$beats,'pages'=>$pages]);
    }
    public function create(){
        $customers   = Customer::get();
        $beats       = Beat::get();
        $products    = Product::with('measurements')->with('inventory')->get();
        $measurement = Measurement::get();
        return view('pages.invoice-requests.generate.layout', ['currentPage' => 'invoiceRequestGenerate', 'beats' => $beats, 'customers' => $customers, 'products' => $products, 'measurements' => $measurement]);        
    }
    public function store(Request $request){
        try {
            $products = collect($request->input('products'));
            $newInvoice = InvoiceRequest::create([
                'customer_id' => $request->input('customer_id'),
                'beat_id' => $request->input('beat_id')
            ]);
            
            foreach ($products as $product) {

                $data = [
                    'invoice_request_id' => $newInvoice->id,
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'quantity' => $product['qty'],
                    'rate'=>$product['rate']
                ];


                InvoiceRequestProduct::create($data);
                
            }
            
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
    public function roundUp($number, $precision = 2) {
        $factor = pow(10, $precision);
        return ceil($number * $factor) / $factor;
    }    

    public function edit(Request $request,$id){
        $invoice_request = InvoiceRequest::where('id',$id)->with('products')->with('customer')->with('beat')->first();
        $customers   = Customer::get();
        $beats       = Beat::get();
        $products    = Product::with('measurements')->with('inventory')->get();
        $measurement = Measurement::get();

        $product_html='';
        $count = count($invoice_request->products);
        foreach($invoice_request->products as $index => $product){
            $product_html .= $this->single_product($request,++$index,$product)->render();
        }

        return view('pages.invoice-requests.edit.layout', ['currentPage' => 'invoiceRequestList', 'beats' => $beats, 'customers' => $customers, 'products' => $products, 'measurements' => $measurement,'invoice_request'=>$invoice_request,'product_html'=>$product_html,'product_count'=>$count]);                
    }

    public function single_product(Request $request,$id,$product){
        $products    = Product::with('measurements')->with('inventory')->get();
        $product_detail    = Product::with('measurements')->where('id',$product->product_id)->get()->first();

        $measurements = $product_detail->measurements; 

        $max_qty_data = $this->max_qty($request,$id,$product->measurement_id);
        
        $filteredProds = [];
        foreach($products as $p){
            if(empty($p->inventory) || $p->total_stock > 0){
                continue;
            }
            array_push($filteredProds,$p);
        }
        $measurement = Measurement::get();
        return view('pages.invoice-requests.edit.product-single',compact('filteredProds','measurement','id','product','measurements','max_qty_data'));
    }        

    public function max_qty(Request $request, $id,$typeId)
    {
        $products    = Product::with('measurements')->with('inventory')->where('id',$id)->get()->first();        
        $total_stock = $products->inventory->total_stock;
        $buying_price = $products->inventory->buying_price; // Min rate

        $measurement = $products->measurements;
        $qty = collect($measurement)->filter(function($value) use ($typeId){
            return $value->id == $typeId;
        })->first();
        
        $maxqty = 0;        
        if(!empty($qty)){
            $q = $qty->quantity;
            $maxqty = $total_stock / $q;
        }
        else{
            $q = 0;
            $maxqty=0;
        }

        return 
            [
                'max_qty'=>$maxqty,
                'min_rate'=>$buying_price
            ];
        
        
    }    

    public function update(Request $request,$id){
        try {
            $products = collect($request->input('products'));
            $newInvoice = InvoiceRequest::where('id',$id)->get()->first();
            
            
            InvoiceRequestProduct::where('invoice_request_id',$id)->delete();
            foreach ($products as $product) {

                $data = [
                    'invoice_request_id' => $newInvoice->id,
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'quantity' => $product['qty'],
                    'rate'=>$product['rate'],
                ];
                InvoiceRequestProduct::create($data);
                
            }

            $success = true;
            $message = 'Invoice Request saved successfully';
        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);                
    }

    public function delete(Request $request,$id){
        $request = InvoiceRequest::findOrFail($id);
        $request->products()->delete();
        $request->delete();
            $success = true;
            $message = 'Invoice Request deleted successfully';        
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);                        
    }

    public function approve(Request $request){
        $invoiceRequests = $request->input('selectedInvoices');
        foreach($invoiceRequests as $request){
            $finalReqData = [];
            $req = InvoiceRequest::where('id',$request)->with('products')->get()->first();
            $finalReqData['beat_id'] = $req->beat_id;
            $finalReqData['customer_id'] = $req->customer_id;

            $products = [];

            foreach($req->products as $p){
                $invRecord = Inventory::where('product_id',$p->product_id)->get()->first();
                $min_rate = $invRecord->buying_price;
                $prod = [
                    'product_id'=>$p->product_id,
                    'measurement_id'=>$p->measurement_id,
                    'qty'=>$p->quantity,
                    'rate'=>$p->rate,
                    'minrate'=>$min_rate
                ];
                array_push($products,$prod);
            }
            $finalReqData['products'] = $products;

            $this->createInvoice($finalReqData);

            // $req->products()->delete();
            // $req->delete();
            }
            $success = true;
            $message = 'Invoice saved successfully';
            return response()->json([
                'success' => $success,
                'message' => $message,
            ]);            

    }

    public function preview(Request $request){
        $invoiceRequests = $request->input('selectedInvoices');
        $time = time();
        $invoiceData = [];
        // Create a new ZIP file in storage
        $zipFileName = 'request_preview'.$time.'.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive();

        // Open the zip file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }

        foreach($invoiceRequests as $request){
            $finalReqData = [];
            $req = InvoiceRequest::where('id',$request)->with('products')->get()->first();
            $finalReqData['beat_id'] = $req->beat_id;
            $finalReqData['customer_id'] = $req->customer_id;

            $products = [];

            foreach($req->products as $p){
                $invRecord = Inventory::where('product_id',$p->product_id)->get()->first();
                $min_rate = $invRecord->buying_price;
                $prod = [
                    'product_id'=>$p->product_id,
                    'measurement_id'=>$p->measurement_id,
                    'qty'=>$p->quantity,
                    'rate'=>$p->rate,
                    'minrate'=>$min_rate
                ];
                array_push($products,$prod);
            }
            $finalReqData['products'] = $products;
            $invoiceData[] = $this->createRequestInvoice(array_merge($finalReqData,['req_id'=>$request]));

            }
        $invoicesArray = ['invoices'=>$invoiceData];
        

            // Generate the PDF for the current invoice
            $pdf = PDF::loadView('pages.pdf-formats.request-preview', $invoicesArray);
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Add the PDF to the zip with a unique filename (e.g., invoice number)
            $zip->addFromString('request_preview_'.$time.'.pdf', $pdfContent);


        // Close the zip file
        $zip->close();
        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('export.csv', ['file' => $zipFileName])
        ]);

    }    

    public function createRequestInvoice($requestData){
        try{
            $total = 0;

            $profit = 0;
            $taxableamt=0;
            $totalgst=0;

            $items = [];
            $boxtotal = 0;
            $pcstotal = 0;
            $totalnetamt = 0;
            $totalgst = 0;
            $taxableamt = 0;


            foreach ($requestData['products'] as $product) {

                $measurement = Measurement::where('id',$product['measurement_id'])->get()->first();

                // Profit = SP-CP * qty
                $sp = $product['rate'];
                $cp = $product['minrate'];
                $pqty = $product['qty'];

                $pd = Product::where('id',$product['product_id'])->get()->first();
                $actualRate = $this->roundUp(($sp * 100) / (100+$pd->gst_rate));
                $inventory = Inventory::where('product_id', $product['product_id'])->get()->first();

                $meas = Measurement::where('id',$product['measurement_id'])->get()->first();

                $data = [
                    'invoice_id' => $requestData['req_id'],
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'quantity' => $product['qty'],
                    'mrp'=>$product['rate'],
                    'rate' => $actualRate,
                    'buying_price'=>$cp,
                ];


                
                $totalDeduction = $measurement->quantity * $product['qty'];


                $taxableamt += $actualRate * $totalDeduction;


                $actualRate = $this->roundUp(($data['mrp'] * 100) / (100+$pd->gst_rate));
                $item = [
                    'qty' => $data['quantity'],
                    'type' => $meas->name,
                    'product_description' => $pd->product_name,
                    'rate' => $actualRate,
                    'entry_rate'=>$sp,
                    'amount' => $data['quantity'] * $actualRate * $meas->quantity,
                    'product_hsn'=>$pd->product_hsn,
                    'box'=>$meas->name!='Piece'?$data['quantity']:0,
                    'pcs'=>$meas->name=='Piece'?$data['quantity']:0,
                    'net_amt'=>(($pd->gst_rate/100)*($actualRate * $meas->quantity * $data['quantity']))+ ($actualRate * $pd->quantity * $data['quantity'])
                ];
                $boxtotal += $meas->name!='Piece'?$data['quantity']:0;
                $pcstotal += $meas->name=='Piece'?$data['quantity']:0;
                $taxableamt += $actualRate * $meas->quantity * $data['quantity'];
                
                $totalnetamt += (($pd->gst_rate/100)*($actualRate * $meas->quantity * $data['quantity']))+ ($actualRate * $meas->quantity * $data['quantity']);
                array_push($items, $item);
            



            $total = collect($items)->sum('amount');
            $grandTotal = $total;

            $customer = Customer::where('id',$requestData['customer_id'])->get()->first();
            $customer_name = $customer->customer_name;

            $beat = Beat::where('id',$requestData['beat_id'])->get()->first();
            $beat_name = $beat->beat_name;

            $request_id = $requestData['req_id'];
            // $date = \Carbon\Carbon::parse($invoice->created_at)->timezone('Asia/Kolkata')->format('d-m-Y');

            // $beat_name = $invoice->beat->beat_name;
            $distributor = Distributor::get()->first();

            $invoiceTotal = round($taxableamt,0);


            $data = compact(
                'items', 
                'total', 
                'grandTotal',
                'boxtotal',
                'pcstotal',
                'totalnetamt',
                'taxableamt',
                'invoiceTotal',
                'customer',
                'beat_name',
                'distributor',
                'request_id',

            );
        }
        return $data;
            

        }
         
         catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }

    }

    public function createInvoice($requestData)
    {
        try {
            $products = collect($requestData['products']);
            $newInvoice = Invoice::create([
                'customer_id' => $requestData['customer_id'],
                'beat_id' => $requestData['beat_id']
            ]);
            
            $invoiceNumber = $newInvoice->id;
            $newInvoice->invoice_number = $invoiceNumber;
            $newInvoice->save();
            $total = 0;

            $profit = 0;
            $taxableamt=0;
            $totalgst=0;
            foreach ($products as $product) {

                $measurement = Measurement::where('id',$product['measurement_id'])->get()->first();

                // Profit = SP-CP * qty
                $sp = $product['rate'];
                $cp = $product['minrate'];
                $pqty = $product['qty'];
                $profit += ($sp-$cp)*$pqty;

                $pd = Product::where('id',$product['product_id'])->get()->first();
                $actualRate = $this->roundUp(($sp * 100) / (100+$pd->gst_rate));
                $inventory = Inventory::where('product_id', $product['product_id'])->get()->first();

                $data = [
                    'invoice_id' => $newInvoice->id,
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'quantity' => $product['qty'],
                    'mrp'=>$product['rate'],
                    'gst'=>($pd->gst_rate/100)*($actualRate * $measurement->quantity * $product['qty']),
                    'rate' => $actualRate,
                    'buying_price'=>$cp,
                    'gst_rate'=>$pd->gst_rate
                ];


                InvoiceProduct::create($data);
                
                $totalDeduction = $measurement->quantity * $product['qty'];


                $taxableamt += $actualRate * $totalDeduction;
                $totalgst += ($pd->gst_rate/100)*($actualRate * $totalDeduction);


                $inventory->total_stock -= $totalDeduction;
                $inventory->save();

                InventoryHistory::create([
                    'product_id' => $product['product_id'],
                    'measurement_id' => $product['measurement_id'],
                    'stock_out_in'   => $totalDeduction,
                    'stock_action'  => 'deduct'
                ]);

            }
            $total = round($taxableamt + $totalgst,0);
            
                CustomerPayment::create([
                    'customer_id'=>$requestData['customer_id'],
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

}