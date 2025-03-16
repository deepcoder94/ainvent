<?php

namespace App\Http\Controllers;

use App\Models\Beat;
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
        // $beatAmt = PaymentHistory::whereDate('created_at',Carbon::today())->with('beat')->get()->toArray();
        // echo "<pre>";print_r($beatAmt);die;
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
}
