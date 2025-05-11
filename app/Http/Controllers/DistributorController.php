<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Measurement;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dist = Distributor::get()->first();
        $measurements = Measurement::get();
        return view('pages.distributor.list',['currentPage'=>'distributor','distributor'=>$dist,'measurements'=>$measurements]);
    }


    public function update(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'address'=>'required|string|max:255',
            'gst_number'=>'required|string|max:255',
            'phone_number'=>'required|string|max:255',
        ]);
        $resource = Distributor::findOrFail(1);
        // Update the resource fields
        $resource->update([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'gst_number' => $request->input('gst_number'),
            'phone_number' => $request->input('phone_number'),
            // Update other fields if necessary
        ]);
        session()->flash('success', 'Resource updated successfully!');

        return redirect()->route('distributor.index');

    }


}
