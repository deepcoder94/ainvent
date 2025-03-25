<?php

namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\InvoiceProfit;
use App\Models\PaymentHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index(){

        $payments = PaymentHistory::
                        whereDate('created_at',Carbon::today())
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
        ->orderBy('created_at', 'asc') // Order by date
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
        $currentPage = 'profitList';
        $profits = InvoiceProfit::get();
        return view('pages.dashboard.profit-list',compact('currentPage','profits'));

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

}
