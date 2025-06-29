<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Customer;
use App\Models\Distributor;
use App\Models\Invoice;
use App\Models\InvoiceProduct;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class InvoiceListController extends Controller
{
    public function list()
    {
        $customers = Customer::get();
        $beats = Beat::get();

        $pages = Invoice::selectRaw('DATE(created_at) as date, count(*) as count')
        ->groupBy(DB::raw('DATE(created_at)'))
        ->orderBy(DB::raw('DATE(created_at)'), 'desc')
        ->get();
        if(count($pages)>0){
            $firstPage = $pages[0]['date'];
            $invoices = Invoice::with('customer')->with('beat')->whereDate('created_at',$firstPage)->orderBy('id','desc')->get();            
        }
        else{
            $invoices=[];
        }
        
        return view('pages.invoice.list.layout', ['currentPage' => 'invoicesList', 'invoices' => $invoices,'customers'=>$customers,'beats'=>$beats,'pages'=>$pages]);
    }


    public function print(Request $request)
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

            foreach ($products as $p) {
                
                if (!$p->product || !$p->measurement) {
                    throw new \Exception('Missing product or measurement for InvoiceProduct ID: ' . $p->id);
                }                
                $actualRate = $this->roundUp(($p->mrp * 100) / (100+$p->product->gst_rate));
                $item = [
                    'qty' => $p->quantity,
                    'type' => $p->measurement->name,
                    'product_description' => $p->product->product_name,
                    'rate' => $actualRate,
                    'amount' => $p->quantity * $actualRate * $p->measurement->quantity,
                    'product_hsn'=>$p->product->product_hsn,
                    'box'=>$p->measurement->name!='Piece'?$p->quantity:0,
                    'pcs'=>$p->measurement->name=='Piece'?$p->quantity:0,
                    'gst_rate'=>$p->product->gst_rate,
                    'gst_amt'=>($p->product->gst_rate/100)*($actualRate * $p->measurement->quantity * $p->quantity),
                    'net_amt'=>(($p->product->gst_rate/100)*($actualRate * $p->measurement->quantity * $p->quantity))+ ($actualRate * $p->measurement->quantity * $p->quantity)
                ];
                $boxtotal += $p->measurement->name!='Piece'?$p->quantity:0;
                $pcstotal += $p->measurement->name=='Piece'?$p->quantity:0;
                $taxableamt += $actualRate * $p->measurement->quantity * $p->quantity;
                
                $totalnetamt += (($p->product->gst_rate/100)*($actualRate * $p->measurement->quantity * $p->quantity))+ ($actualRate * $p->measurement->quantity * $p->quantity);
                $totalgst += ($p->product->gst_rate/100)*($actualRate * $p->measurement->quantity * $p->quantity);
                array_push($items, $item);
            }



            $total = collect($items)->sum('amount');
            $grandTotal = $total;
            $customer = $invoice->customer;
            $invoice_number = $invoice->id;
            $date = \Carbon\Carbon::parse($invoice->created_at)->timezone('Asia/Kolkata')->format('d-m-Y');
            $beat_name = $invoice->beat->beat_name;
            $distributor = Distributor::get()->first();

            $invoiceTotal = round($taxableamt + $totalgst,0);


            $data = compact('items', 'total', 'grandTotal', 'customer', 'invoice_number', 'date', 'beat_name', 'distributor','boxtotal','pcstotal','totalnetamt','totalgst','taxableamt','invoiceTotal');
            $finalArray[] = $data;
        }
        $invoicesArray = ['invoices'=>$finalArray];
        // dd($invoicesArray);

            // Generate the PDF for the current invoice
            $pdf = PDF::loadView('pages.pdf-formats.invoice', $invoicesArray);
            $pdf->setPaper('A4');
            $pdfContent = $pdf->output();

            // Add the PDF to the zip with a unique filename (e.g., invoice number)
            $zip->addFromString('invoices.pdf', $pdfContent);


        // Close the zip file
        $zip->close();

        // Prepare the zip file for download
        return response()->json([
            'zipUrl' => route('export.csv', ['file' => $zipFileName])
        ]);
    }

    public function roundUp($number, $precision = 2) {
        $factor = pow(10, $precision);
        return ceil($number * $factor) / $factor;
    }
        

    public function search(Request $request){
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
        return view('pages.invoice.list.single',['invoices'=>$records]);

    }

    public function view(Request $request,$id){
        $invoice = Invoice::with('customer')->with('beat')->find($id);
        $products = InvoiceProduct::where('invoice_id', $id)->with('product')->with('measurement')->get();

        $items = [];
        foreach ($products as $p) {
            $item = [
                'qty' => $p->quantity,
                'type' => $p->measurement->name??'-',
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
        return view('pages.pdf-formats.return-invoice',$invoicesArray);

    }

    public function products(Request $request,$id,$index){
        $invoices = Invoice::where('id',$id)->with('invoiceproducts')->with('invoicemeasurements')->get()->first();
        return view('pages.returns.new-return-product',['products'=>$invoices->invoiceproducts,'count'=>$index,'measurements'=>$invoices->invoicemeasurements[0]]);
    }    

}
