<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;
use Carbon\Carbon;

class ShipmentController extends Controller
{


    public function createShipment(Request $request)
    {
        $invoices = $request->input('selectedInvoices');

        $items = [];
        $currentDate = Carbon::now()->format('d-m-Y'); // Format the date as you want

        // Create a new ZIP file in storage
        $zipFileName = 'shipments_'.$currentDate.'.zip';
        $zipFilePath = storage_path('app/' . $zipFileName);
        $zip = new ZipArchive();
        // Open the zip file for writing
        if ($zip->open($zipFilePath, ZipArchive::CREATE) !== TRUE) {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
        foreach ($invoices as $i) {
            // Fetch invoice data
            $invoice = Invoice::with('customer')->with('beat')->where('id',$i)->get()->first();
            $products = InvoiceProduct::where('invoice_id', $i)->with('product')->with('measurement')->get();

            foreach ($products as $p) {

                $inventory = Inventory::where('product_id', $p->product_id)->get()->first();
                $item_code = $inventory->item_code;


                $item = [
                    'item_code'=>$item_code,
                    'qty' => $p->quantity,
                    'type' => $p->measurement->name,
                    'product_description' => $p->product->product_name,
                    'rate' => $p->rate,
                    'amount' => $p->quantity * $p->rate * $p->measurement->quantity,
                    'gst' => $p->gst,
                    'total_quantity' => $p->quantity * $p->measurement->quantity
                ];
                array_push($items, $item);
            }


            $total = $invoice->invoice_total;
            $grandTotal = round($total);

            $data = compact('items', 'total', 'grandTotal');

            Shipment::create(['invoice_id'=>$i]);
        }
        $products = collect($data['items'])
        ->groupBy('product_description') // Group by product_description
        ->toArray();


        $finalitems = [];
        foreach($products as $p){
            
            $totalq = 0;
            $pc = 0;
            $case = 0;
            $totalgst = 0;
            $totalamount=0;
            $pro = [];
            foreach($p as $item){
                $totalq += $item['total_quantity'];
                $pc += str_contains($item['type'],'Piece')?$item['qty']:0;
                $case += str_contains($item['type'],'Case')?$item['qty']:0;
                $totalamount += $item['amount'];
                $totalgst += $item['gst'];
                $item_code = $item['item_code'];
                $gst = $item['gst'];
                $product_description = $item['product_description'];                
            }
            $pro = [
                'qty_count'=>$totalq,
                'piece_count'    =>$pc,
                'case_count' =>$case,
                'product_total_amount' =>$totalamount,
                'item_code' =>$item_code,
                'product_gst' =>$gst,
                'product_description' => $product_description,
            ];
            array_push($finalitems,$pro);
        }

        $gstTotal = collect($finalitems)->sum('product_gst');
        $shipmentTotal = collect($finalitems)->sum('product_total_amount') + $gstTotal;
        $shipmentCaseTotal = collect($finalitems)->sum('case_count');
        $shipmentPcTotal = collect($finalitems)->sum('piece_count');
        $shipmentQtyTotal = collect($finalitems)->sum('qty_count');

        $data = compact('finalitems','shipmentTotal','shipmentCaseTotal','shipmentPcTotal','shipmentQtyTotal','currentDate','gstTotal');


        $pdf = PDF::loadView('pages.pdf-formats.shipment', $data);
        $pdf->setPaper('A4');
        $pdfContent = $pdf->output();

        // Add the PDF to the zip with a unique filename (e.g., invoice number)
        $zip->addFromString('shipment_'.$currentDate.'.pdf', $pdfContent);

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

    public function shipmentList()
    {
        $invoices = Invoice::with('customer')->with('beat')->orderBy('id','desc')->get();
        $data = [];
        foreach($invoices as $invoice){
            $data[] = [
                'invoice'=>$invoice,
                'status'=> !empty(Shipment::where('invoice_id', $invoice->id)->get()->first()) ? 1:0
            ];
        }
        return view('pages.shipments.list', ['currentPage' => 'shipmentList', 'shipments' => $data]);       
    }
}
