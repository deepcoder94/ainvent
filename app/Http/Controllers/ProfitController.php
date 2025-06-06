<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InvoiceProduct;


use Carbon\Carbon;


class ProfitController extends Controller
{
    
    public function list(Request $request){
        
        $perPage = 10;        
        $currentPageNum = 1;
        
        $prods2 = InvoiceProduct::with('invoice')->with('measurement')->with('product')->orderBy('created_at', 'desc')->get()->toArray();
        $groupedData2 = collect($prods2)->groupBy('invoice_id')->map(function ($invoiceItems) {
            // For each invoice group, calculate the total profit
            $profit = 0;
            foreach($invoiceItems as $i){
                $profit += (($i['mrp'] ?? 0) - ($i['buying_price'] ?? 0)) * ($i['quantity'] ?? 0) * ($i['measurement']['quantity'] ?? 0);
            }

            // $invoice = $invoiceItems->first(); // Get the first item to retrieve invoice details (like created_at)
            // $totalProfit = $invoiceItems->sum(function ($item) {                
            //     // $sp = $this->calculateSp($item['rate'],$item['product']['gst_rate']);
            //     return (($item['buying_price'] - $item['mrp']) * $item['quantity']) * $item['measurement']['quantity'];
            // });
        
            return [
                'created_at' => $invoiceItems[0]['created_at'], // You can take created_at from any item in the group
                'gst_invoice_id' => $invoiceItems[0]['invoice_id'],
                'total_profit' => round($profit),
                'invoice_number' => $invoiceItems[0]['invoice']['invoice_number'], // Invoice number
            ];
        });        

        $mergedCollection = $groupedData2;
        
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
        
        $view = 'pages.profit.list';
        if($isSingleView){
            $view = 'pages.profit.single';
        }
        

        $groupedData = $mergedCollection->all();

        return view($view,compact('currentPage','groupedData','perPage','currentPageNum','total_records','totalpagnums'));

    }

    public function calculateSp($actualRate, $gst_rate) {
        $sp = ($actualRate * (100 + $gst_rate)) / 100;
        return round($sp,0); // Apply rounding to the result
    }
    
    public function roundUp($number, $precision = 2) {
        $factor = pow(10, $precision);
        return ceil($number * $factor) / $factor;
    }    
    
    public function export(){
        

        $prods2 = InvoiceProduct::with('invoice')->with('measurement')->with('product')->orderBy('created_at', 'desc')->get()->toArray();
        $groupedData2 = collect($prods2)->groupBy('invoice_id')->map(function ($invoiceItems) {
            // For each invoice group, calculate the total profit

            $profit = 0;
            foreach($invoiceItems as $i){
                $profit += ($i['mrp'] - $i['buying_price']) * $i['quantity'] * $i['measurement']['quantity'];
            }

            // $invoice = $invoiceItems->first(); // Get the first item to retrieve invoice details (like created_at)
            // $totalProfit = $invoiceItems->sum(function ($item) {
            //     return (($item['buying_price'] - $item['mrp']) * $item['quantity']) * $item['measurement']['quantity'];

            //     // $sp = $this->calculateSp($item['rate'],$item['product']['gst_rate']);
            //     // return (($sp - $item['buying_price']) * $item['quantity']) * $item['measurement']['quantity'];                
            // });
        
            return [
                'created_at' => \Carbon\Carbon::parse($invoiceItems[0]['created_at'])->timezone('Asia/Kolkata')->format('d-m-Y'), // You can take created_at from any item in the group
                'gst_invoice_id' => $invoiceItems[0]['invoice_id'],
                'total_profit' => $profit,
                'invoice_number' => $invoiceItems[0]['invoice']['invoice_number'], // Invoice number
            ];
        });        
        
        $mergedCollection = $groupedData2;
        
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
