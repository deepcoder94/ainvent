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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Distributor $distributor)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $distributor)
    {
        //
    }

    public function updateCompany(Request $request){
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

    public function createMeasurement(Request $request){
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'quantity' => 'required|string',
            ]);

            $beat = Measurement::create([
                'name'    => $request->name,
                'quantity' => $request->quantity,
            ]);
            $success = true;
            $message = 'Measurement saved successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    public function updateMeasurementById(Request $request,$id){
        try {
            $validated = $request->validate([
                'name'    => 'required|string|max:255',
                'quantity' => 'required|string',
            ]);
            $resource = Measurement::findOrFail($id);

            $beat = $resource->update([
                'name'    => $request->name,
                'quantity' => $request->quantity,
            ]);
            $success = true;
            $message = 'Measurement updated successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }
    
    public function deleteMeasurementById(Request $request,$id){
        $measurement = Measurement::find($id);
        // If the resource doesn't exist, return an error response
        if (! $measurement) {
            return response()->json([
                'message' => 'Resource not found.',
            ], 404);
        }

        $measurement->delete();
        // Return a success response
        return response()->json([
            'message' => 'Resource deleted successfully.',
        ]);
    }
    

}
