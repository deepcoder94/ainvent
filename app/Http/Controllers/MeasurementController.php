<?php

namespace App\Http\Controllers;

use App\Models\Distributor;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{

    public function view(Request $request,$id){
        $resource = Measurement::findOrFail($id);
        return response()->json([
            'data'=>$resource,
            'message' => 'Resource fetched successfully.',
        ]);
    }

    public function create(Request $request){
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

    public function update(Request $request,$id){
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
    
    public function delete(Request $request,$id){
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
