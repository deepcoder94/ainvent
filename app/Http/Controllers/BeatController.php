<?php
namespace App\Http\Controllers;

use App\Models\Beat;
use App\Models\Customer;
use Illuminate\Http\Request;

class BeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $beats = Beat::get();
        return view('pages.beats.list', ['currentPage' => 'beats', 'beats' => $beats]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'beat_name'    => 'required|string|max:255',
                'beat_address' => 'required|string',
                'is_active'    => 'required',
            ]);

            $beat = Beat::create([
                'beat_name'    => $request->beat_name,
                'beat_address' => $request->beat_address,
                'is_active'    => $request->is_active,
            ]);
            $success = true;
            $message = 'beat saved successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }

    
    public function view(Request $request, $id)
    {
        $resource = Beat::findOrFail($id);
        return response()->json([
            'data' => $resource,
            'message' => 'Data fetched success'
        ]);        
    }

    public function edit(Request $request, $id){
        try {
            $validated = $request->validate([
                'beat_name'    => 'required|string|max:255',
                'beat_address' => 'required|string',
                'is_active'    => 'required',
            ]);
            $resource = Beat::findOrFail($id);

            $beat = $resource->update([
                'beat_name'    => $request->beat_name,
                'beat_address' => $request->beat_address,
                'is_active'    => $request->is_active,
            ]);
            $success = true;
            $message = 'beat updated successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);

    }


    public function delete(Request $request, $id)
    {
        $beat = Beat::find($id);
        // If the resource doesn't exist, return an error response
        if (! $beat) {
            return response()->json([
                'message' => 'Resource not found.',
            ], 404);
        }

// Delete the resource
        $customers = Customer::where('beat_id',$id)->get();
        foreach($customers as $customer){
            Customer::destroy($customer->id);
        }
        $beat->delete();
        // Return a success response
        return response()->json([
            'message' => 'Resource deleted successfully.',
        ]);
    }

    public function customers(Request $request, $id)
    {
        $customers   = Customer::where('beat_id',$id)->get();
        return response()->json([
            'customers'=>$customers
        ]);
    }
}
