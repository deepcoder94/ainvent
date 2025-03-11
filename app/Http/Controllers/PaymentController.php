<?php
namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;

class PaymentController extends Controller
{
    public function paymentsList(){
        $customerpayments=[];
        $beats     = Beat::get();
        return view('pages.payments.list', ['currentPage' => 'customer_payments', 'customerpayments' => $customerpayments, 'beats' => $beats]);

    }

    public function paymentsUpdate(Request $request,$id){
        try{

            if($request->isBeatCustomer == 1){
                $resource = CustomerPayment::findOrFail($id);
                $payment = $resource->update([
                    'total_due'    => $request->due,
                    'invoice_total'=> 0
                ]);
            }
            if($request->isBeatCustomer == 0){
                $p = CustomerPayment::where('customer_id',$id)->get()->first();
                $existingDue = $p->total_due;
                $invDue = $request->due;

                $final = $existingDue - $invDue;
                $payment = $p->update([
                    'total_due'    => $final,
                    'invoice_total'=> 0
                ]);
            }
            

            $success = true;
            $message = 'Customer updated successfully';
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

    public function getPaymentsByBeat(Request $request,$beatId){
        // $customerpayments = CustomerPayment::with('customer')->where('')->get();
       $customerpayments =  CustomerPayment::with('customer')
    ->whereHas('customer', function ($query) use ($beatId) {
        $query->where('beat_id', $beatId);
    })
    ->where('total_due','>',0)
    ->get();
    return view('pages.payments.customer-single',['customerpayments'=>$customerpayments]);
    }

    public function getPaymentsByInvoiceId(Request $request,$invoiceId){
        $invoice = Invoice::with('customer')->with('beat')->where('invoice_number',$invoiceId)->get()->first();
        $data = [];
        if(!empty($invoice)){
            $products = InvoiceProduct::where('invoice_id', $invoice->id)->with('product')->with('measurement')->get();
            $items = [];

            foreach ($products as $p) {

                $inventory = Inventory::where('product_id', $p->product_id)->get()->first();
                $item_code = $inventory->item_code;


                $item = [
                    'item_code'=>$item_code,
                    'qty' => $p->quantity,
                    'type' => $p->measurement->name,
                    'product_description' => $p->product->product_name,
                    'rate' => $p->product->product_rate,
                    'amount' => $p->quantity * $p->product->product_rate * $p->measurement->quantity,
                    'total_quantity' => $p->quantity * $p->measurement->quantity
                ];
                array_push($items, $item);
            }
            $total = collect($items)->sum('amount');
            $grandTotal = $total;
            $data['invoice_total'] = $grandTotal;
            $data['invoice_number'] = $invoice->invoice_number;
            $data['invoice_id'] = $invoice->id;
            $data['customer_id'] = $invoice->customer->id;
        }
        return view('pages.payments.invoice-single',['customerpayments'=>$data]);


    }

}
