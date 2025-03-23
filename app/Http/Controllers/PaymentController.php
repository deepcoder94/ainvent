<?php
namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\CustomerPayment;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\PaymentHistory;
use App\Models\Customer;


class PaymentController extends Controller
{
    public function paymentsList(){
        $customerpayments=[];
        $beats     = Beat::get();
        return view('pages.payments.list', ['currentPage' => 'customer_payments', 'customerpayments' => $customerpayments, 'beats' => $beats]);

    }

    public function paymentsUpdate(Request $request,$id){
        try{

            $invoiceid = $request->invoiceid;
            if($request->isBeatCustomer == 1){
                $resource = CustomerPayment::where('invoice_id',$invoiceid)->where('id',$id)->get()->first();
                $payment = $resource->update([
                    'total_due'    => $request->due,
                    'invoice_total'=> 0
                ]);
            }
            if($request->isBeatCustomer == 0){
                $p = CustomerPayment::where('customer_id',$request->customerid)->where('invoice_id',$invoiceid)->get()->first();
                $invDue = $request->due;

                $payment = $p->update([
                    'total_due'    => $invDue,
                    'invoice_total'=> 0
                ]);
            }

            CustomerPayment::where('invoice_total',0)->where('total_due',0)->delete();

            $Customer = Customer::where('id',$request->customerid)->get()->first();

            PaymentHistory::create([
                'customer_id'=>$request->customerid,
                'beat_id'=>$Customer->beat_id,
                'invoice_id'=>$invoiceid,
                'amount'=>floatval($request->paid_total)
            ]);
            

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
       $customerpayments =  CustomerPayment::with('customer')->with('invoice')
    ->whereHas('customer', function ($query) use ($beatId) {
        $query->where('beat_id', $beatId);
    })
    ->where('total_due','>',0)
    ->get();
    return view('pages.payments.customer-single',['customerpayments'=>$customerpayments]);
    }

    public function getPaymentsByInvoiceId(Request $request,$invoiceId){
        $inv = Invoice::where('invoice_number',$invoiceId)->get()->first();
        if(empty($inv)){
            return view('pages.payments.invoice-single',['customerpayments'=>[]]);            
        }
        $id = $inv->id;

        $customerpayments =  CustomerPayment::with('customer')->with('invoice')
        ->whereHas('customer', function ($query) use ($id) {
            $query->where('invoice_id', $id);
        })
        ->where('total_due','>',0)
        ->get()->first();
    
        // $invoice = Invoice::with('customer')->with('beat')->where('invoice_number',$invoiceId)->get()->first();
        // $data = [];
        // if(!empty($invoice)){
        //     $products = InvoiceProduct::where('invoice_id', $invoice->id)->with('product')->with('measurement')->get();
        //     $items = [];

        //     foreach ($products as $p) {

        //         $inventory = Inventory::where('product_id', $p->product_id)->get()->first();
        //         $item_code = $inventory->item_code;


        //         $item = [
        //             'item_code'=>$item_code,
        //             'qty' => $p->quantity,
        //             'type' => $p->measurement->name,
        //             'product_description' => $p->product->product_name,
        //             'rate' => $p->product->product_rate,
        //             'amount' => $p->quantity * $p->product->product_rate * $p->measurement->quantity,
        //             'total_quantity' => $p->quantity * $p->measurement->quantity
        //         ];
        //         array_push($items, $item);
        //     }
        //     $total = collect($items)->sum('amount');
        //     $grandTotal = $total;
        //     $data['invoice_total'] = $grandTotal;
        //     $data['invoice_number'] = $invoice->invoice_number;
        //     $data['invoice_id'] = $invoice->id;
        //     $data['customer_id'] = $invoice->customer->id;
        // }
        return view('pages.payments.invoice-single',['customerpayments'=>$customerpayments]);


    }

    public function paymentHistory(){
        $currentPage = 'payment_history';
        $invoices = Invoice::with('payments')->with('customer')->orderBy('id','desc')->get()->toArray();
    // Convert the array into a collection
    $invoicesCollection = collect($invoices);

    // Filter the invoices to keep only those that have at least one payment
    $filteredInvoices = $invoicesCollection->filter(function ($invoice) {
        return count($invoice['payments']) > 0;
    });
        return view('pages.payment-history.list',compact('currentPage','filteredInvoices'));
    }

    public function getSingleInvoicePaymentDetail(Request $request,$id){
        $history = PaymentHistory::where('invoice_id',$id)->get();
        return view('pages.payment-history.single-invoice-history',compact('history'));
    }

    public function searchPayHistory(Request $request,$id){
        $query = Invoice::query();
        if($id !='all'){
            $query->where('invoice_number',$id);
        }
        $invoices = $query->with('payments')->with('customer')->orderBy('id','desc')->get()->toArray();
        // Convert the array into a collection
        $invoicesCollection = collect($invoices);

        // Filter the invoices to keep only those that have at least one payment
        $filteredInvoices = $invoicesCollection->filter(function ($invoice) {
            return count($invoice['payments']) > 0;
        });        
        return view('pages.payment-history.single-payment',compact('filteredInvoices'));
    }
}
