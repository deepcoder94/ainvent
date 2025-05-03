<?php

namespace App\Http\Controllers;
use App\Models\Beat;
use App\Models\Customer;
use App\Models\CustomerPayment;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;

use App\Models\Measurement;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\InventoryHistory;

class GenerateInvoiceController extends Controller
{
    public function index()
    {
        $customers   = Customer::get();
        $beats       = Beat::get();
        $products    = Product::with('measurements')->with('inventory')->get();
        $measurement = Measurement::get();
        return view('pages.invoice.generate.layout', ['currentPage' => 'invoiceGenerateNew', 'beats' => $beats, 'customers' => $customers, 'products' => $products, 'measurements' => $measurement]);
    }    

    public function create(Request $request)
    {
        try {
            $products = collect($request->input('products'));
            $newInvoice = Invoice::create([
                'customer_id' => $request->input('customer_id'),
                'beat_id' => $request->input('beat_id')
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

    public function roundUp($number, $precision = 2) {
        $factor = pow(10, $precision);
        return ceil($number * $factor) / $factor;
    }
    
    
    public function getMeasurementsByProduct(Request $request,$id){
        $products    = Product::with('measurements')->with('inventory')->where('id',$id)->get()->first();

        return response()->json([
            'data'=>$products->measurements
        ]);
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
        return view('pages.invoice.generate.product-single',compact('filteredProds','measurement','id'));
    }    

    public function getCustomersByBeat(Request $request,$id){
        $customers   = Customer::where('beat_id',$id)->get();
        return response()->json([
            'customers'=>$customers
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
                'max_qty'=>($total_stock/$qty),2,
                'min_rate'=>$buying_price
            ]
        );
    }    
}