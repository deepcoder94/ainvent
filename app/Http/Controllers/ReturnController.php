<?php

namespace App\Http\Controllers;

use App\Models\CustomerPayment;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Measurement;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public $count =0;
    public function showReturnForm(){
        $invoices = Invoice::all();
        
        $currentPage = 'returns';
        $invProducts = [];
        $returnProducts = [];

        $data = compact('invoices','currentPage','invProducts','returnProducts');
        return view('pages.returns.form', $data);        
    }

    public function getInvoiceProducts(Request $request,$id,$index){
        $invoices = Invoice::where('id',$id)->with('invoiceproducts')->with('invoicemeasurements')->get()->first();
        return view('pages.returns.new-return-product',['products'=>$invoices->invoiceproducts,'count'=>$index,'measurements'=>$invoices->invoicemeasurements[0]]);
    }

    public function submitReturn(Request $request){
        
        try{

            $products = collect($request->input('products'))->toArray();  
            $invoice_id = $request->input('invoice_id');
            $invoiceI = Invoice::where('id',$invoice_id)->get()->first();
            $Measurement = Measurement::where('name','Piece')->get()->first();
            foreach($products as $p){
                $totalqty = $Measurement->quantity * floatval($p['quantity']);
                $invpro = InvoiceProduct::where('invoice_id',$invoiceI->id)->where('product_id',$p['invoiceProduct'])->with('measurement')->get()->first();
    //            add stock in inventory            
                $inv = Inventory::where('product_id',$p['invoiceProduct'])->get()->first();
                $rate = $invpro->rate;
                $inv->total_stock += $Measurement->quantity * floatval($p['quantity']);
                $inv->save();
    
            // inventory history add
                InventoryHistory::create([
                    'product_id'=>$p['invoiceProduct'],
                    'measurement_id'=>$Measurement->id,
                    'stock_out_in'=>$Measurement->quantity * floatval($p['quantity']),
                    'stock_action'=>'return',
                    'buying_price'=>'0'
                ]);
    
            // customer payment minus
                $pay = CustomerPayment::where('customer_id',$invoiceI->customer_id)->get()->first();
                // Diff between due and return
                if($pay->invoice_total > 0){
                    $pay->invoice_total -= ($totalqty * $rate);
                    $invoiceI->invoice_amount -=  ($totalqty * $rate);
                }        
                else{
                    $pay->total_due -= ($totalqty * $rate);
                }
                $pay->save();
                $invoiceI->save();
    
    
                // invoice product delete
                if($invpro->measurement->name != 'Piece'){
                    $singleQty = 1 / $invpro->measurement->quantity; 
                    $finalqty = number_format($invpro->quantity - ($singleQty * floatval($p['quantity'])),2);
                }
                else{
                    $finalqty = $invpro->quantity - floatval($p['quantity']);
                }
    
                $invpro->quantity = $finalqty;
                $invpro->save();
    
            }
                    
            $success = true;
            $message = 'Return success';
        }
        catch(\Exception $e){
            $success = false;
            $message = $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);        

    }
}