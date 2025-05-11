<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PaymentHistory;


class PaymentHistoryController extends Controller
{

    public function list(){
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

    public function view(Request $request,$id){
        $history = PaymentHistory::where('invoice_id',$id)->get();
        return view('pages.payment-history.single-invoice-history',compact('history'));        
    }    


    public function search(Request $request,$id){
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
