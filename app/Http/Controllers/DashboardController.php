<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\InvoiceProfit;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use App\Models\GstInvoiceProduct;


use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(){

        $payments = PaymentHistory::
                        whereDate('created_at',Carbon::today())
                        ->orderBy('id','desc')
                        ->sum('amount');
        $total_pay = number_format($payments,3);
        $currentPage = 'dashboard';
        $today = Carbon::today();

        // Get all beats with their payments that were created today
        $beats = Beat::with(['payments' => function($query) use ($today) {
            $query->whereDate('created_at', $today); // Filter payments created today
        }])->get();

        // Now, iterate over each beat and get the sum of the payments for that beat
        $beatsSum = $beats->map(function($beat) {
            $totalAmount = $beat->payments->sum('amount'); // Sum the amounts for the current beat
            return [
                'beat_name' => $beat->beat_name,
                'total_amount' => $totalAmount,
            ];
        })->toArray();
        return view('pages.dashboard.index',compact('currentPage','beatsSum','total_pay'));
    }

    public function salesList(Request $request){
        $currentPage = 'salesList';

        $payments = PaymentHistory::with('beat')  // Eager load the 'beat' relationship
        ->orderBy('created_at', 'desc') // Order by date
        ->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->toDateString(); // Group by date
        })
        ->map(function($dateGroup) {
            return $dateGroup->groupBy('beat_id')->map(function($beatGroup) {
                // Get the total amount for each beat_id and add the beat_name
                $beatName = $beatGroup->first()->beat->beat_name; // Get the beat_name from the first payment in the group
                $totalAmount = $beatGroup->sum('amount'); // Sum the amounts for each beat_id
                return [
                    'beat_name' => $beatName,
                    'total_amount' => $totalAmount
                ];
            });
        });        

        $beats = Beat::get();

        return view('pages.dashboard.sales-list',compact('currentPage','payments','beats'));
    }
    
    public function profitList(Request $request){
        $perPage = 10;        
        $currentPageNum = 1;
        
        $prods = GstInvoiceProduct::with('invoice')->orderBy('created_at', 'desc')->get()->toArray();
        $groupedData = collect($prods)->groupBy('gst_invoice_id')->map(function ($invoiceItems) {
            // For each invoice group, calculate the total profit
            $invoice = $invoiceItems->first(); // Get the first item to retrieve invoice details (like created_at)
            $totalProfit = $invoiceItems->sum(function ($item) {
                return ($item['unit_price'] - $item['buying_price']) * $item['quantity'];
            });
        
            return [
                'created_at' => $invoice['created_at'], // You can take created_at from any item in the group
                'gst_invoice_id' => $invoice['gst_invoice_id'],
                'total_profit' => $totalProfit,
                'invoice_number' => $invoice['invoice']['invoice_number'], // Invoice number
            ];
        });
        
        $prods2 = InvoiceProduct::with('invoice')->with('measurement')->orderBy('created_at', 'desc')->get()->toArray();
        $groupedData2 = collect($prods2)->groupBy('invoice_id')->map(function ($invoiceItems) {
            // For each invoice group, calculate the total profit
            $invoice = $invoiceItems->first(); // Get the first item to retrieve invoice details (like created_at)
            $totalProfit = $invoiceItems->sum(function ($item) {
                return (($item['rate'] - $item['buying_price']) * $item['quantity']) * $item['measurement']['quantity'];
            });
        
            return [
                'created_at' => $invoice['created_at'], // You can take created_at from any item in the group
                'gst_invoice_id' => $invoice['invoice_id'],
                'total_profit' => $totalProfit,
                'invoice_number' => $invoice['invoice']['invoice_number'], // Invoice number
            ];
        });        
        
        $mergedCollection = $groupedData->merge($groupedData2);
        
        $groupedData = $mergedCollection->sortByDesc('created_at');

        $currentPage = 'profitList';
        $total_records = count($mergedCollection);
        $pageNums = $total_records / $perPage; 
        $totalpagnums = is_float($pageNums) ? (int)$pageNums + 1 : $pageNums;
        $isSingleView = false;
        
        if(!empty($request->input('perPage'))){
            $perPage = $request->input('perPage');
            $isSingleView = true;
        }
        if(!empty($request->input('currentPageNum'))){
            $currentPageNum = $request->input('currentPageNum');
            $isSingleView = true;

        }
        
        $view = 'pages.dashboard.profit-list';
        if($isSingleView){
            $view = 'pages.dashboard.profit-list-single';
        }
        

        $groupedData = $mergedCollection->take($perPage)->skip($currentPageNum)->all();

        return view($view,compact('currentPage','groupedData','perPage','currentPageNum','total_records','totalpagnums'));

    }

    public function searchSales(Request $request){
        $date = $request->date;
        $selectedBeat = $request->selectedBeat;

 // Build the query
    $paymentsQuery = PaymentHistory::with('beat')
        ->orderBy('created_at', 'asc');

    // Filter by date if provided
    if ($date && $date!='all') {
        $paymentsQuery->whereDate('created_at', Carbon::parse($date)->format('Y-m-d'));
    }

    // Filter by beat_id if provided
    if ($selectedBeat && $selectedBeat!='all') {
        $paymentsQuery->where('beat_id', $selectedBeat);
    }

    // Get the payments, grouped by date and beat
    $payments = $paymentsQuery->get()
        ->groupBy(function($date) {
            return Carbon::parse($date->created_at)->toDateString(); // Group by date
        })
        ->map(function($dateGroup) {
            return $dateGroup->groupBy('beat_id')->map(function($beatGroup) {
                $beatName = $beatGroup->first()->beat->beat_name;
                $totalAmount = $beatGroup->sum('amount');
                return [
                    'beat_name' => $beatName,
                    'total_amount' => $totalAmount
                ];
            });
        });   
        
        $beats = Beat::get();
        return view('pages.dashboard.sales-list-single',compact('beats','payments'));

    }
    
    public function profitExport(){
        

        $prods = GstInvoiceProduct::with('invoice')->orderBy('created_at', 'desc')->get()->toArray();
        $groupedData = collect($prods)->groupBy('gst_invoice_id')->map(function ($invoiceItems) {
            // For each invoice group, calculate the total profit
            $invoice = $invoiceItems->first(); // Get the first item to retrieve invoice details (like created_at)
            $totalProfit = $invoiceItems->sum(function ($item) {
                return ($item['unit_price'] - $item['buying_price']) * $item['quantity'];
            });
        
            return [
                'created_at' => $invoice['created_at'], // You can take created_at from any item in the group
                'gst_invoice_id' => $invoice['gst_invoice_id'],
                'total_profit' => $totalProfit,
                'invoice_number' => $invoice['invoice']['invoice_number'], // Invoice number
            ];
        });
        
        $prods2 = InvoiceProduct::with('invoice')->with('measurement')->orderBy('created_at', 'desc')->get()->toArray();
        $groupedData2 = collect($prods2)->groupBy('invoice_id')->map(function ($invoiceItems) {
            // For each invoice group, calculate the total profit
            $invoice = $invoiceItems->first(); // Get the first item to retrieve invoice details (like created_at)
            $totalProfit = $invoiceItems->sum(function ($item) {
                return (($item['rate'] - $item['buying_price']) * $item['quantity']) * $item['measurement']['quantity'];
            });
        
            return [
                'created_at' => \Carbon\Carbon::parse($invoice['created_at'])->timezone('Asia/Kolkata')->format('d-m-Y'), // You can take created_at from any item in the group
                'gst_invoice_id' => $invoice['invoice_id'],
                'total_profit' => $totalProfit,
                'invoice_number' => $invoice['invoice']['invoice_number'], // Invoice number
            ];
        });        
        
        $mergedCollection = $groupedData->merge($groupedData2);
        
        $groupedData = $mergedCollection->sortByDesc('created_at');        
        
        // Generate the filename
        $filename = 'profits-' . now()->timestamp . '.csv';

        // Define the path where the file will be stored
        $filePath = storage_path('app/' . $filename);

        // Open the file for writing
        $handle = fopen($filePath, 'w');

        // Add the CSV column headings (optional)
        fputcsv($handle, ['Date', 'Total Profit', 'Invoice number']);

        // Loop through the data and write each row to the CSV file
        foreach ($groupedData as $d) {
            // Write the product row to the CSV
            fputcsv($handle, [
                $d['created_at'],
                $d['total_profit'],
                $d['invoice_number'],
            ]);
        }

        // Close the file handle
        fclose($handle);

        // Return the file path so it can be used for the download
        return response()->json(['url_path'=> route('download.product.csv',['file'=>$filename])]);
    }

}
