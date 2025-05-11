<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use App\Models\Product;
use App\Models\ProductMeasurement;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        $products = Product::with('measurements')->get();
        $measurements = Measurement::all();
        return view('pages.products.list', ['currentPage' => 'products', 'products' => $products,'measurements' => $measurements]);        
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_name'    => 'required|string|max:255',
                'product_rate' => 'required|numeric',
                'is_active'    => 'required',
                'product_hsn'    => 'required',
                'gst_rate'    => 'required',                
            ]);

            $product = Product::create([
                'product_name'    => $request->product_name,
                'product_rate' => $request->product_rate,
                'is_active'    => $request->is_active,
                'product_hsn'    => $request->product_hsn,
                'gst_rate'    => $request->gst_rate,                
            ]);

            $product_measurements = $request->product_measurements;
            ProductMeasurement::where('product_id',$product->id)->delete();
            foreach ($product_measurements as $m){
                ProductMeasurement::firstOrCreate([
                    'product_id' => $product->id,
                    'measurement_id'=>$m
                ]);    
            }

            $success = true;
            $message = 'Products saved successfully';

        } catch (\Exception $e) {
            $success = false;
            $message = $e->getMessage();
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);        
    }

    public function view(Request $request,$id){
        $resource = Product::where('id',$id)->with('measurements')->get()->first();
        return response()->json([
            'data' => $resource,
            'message' => 'Data fetched',
        ]);                
    }    


    public function edit(Request $request,$id){
        try {
            $validated = $request->validate([
                'product_name'    => 'required|string|max:255',
                'product_rate' => 'required',
                'is_active'    => 'required',
                'product_hsn'    => 'required',
                'gst_rate'    => 'required',                
            ]);
            $resource = Product::findOrFail($id);

            $product = $resource->update([
                'product_name'    => $request->product_name,
                'product_rate' => $request->product_rate,
                'is_active'    => $request->is_active,
                'product_hsn'    => $request->product_hsn,
                'gst_rate'    => $request->gst_rate,                
            ]);
            $product_measurements = $request->product_measurements;
            ProductMeasurement::where('product_id',$resource->id)->delete();
            foreach ($product_measurements as $m){
                ProductMeasurement::firstOrCreate([
                    'product_id' => $resource->id,
                    'measurement_id'=>$m
                ]);    
            }

            $success = true;
            $message = 'Product updated successfully';

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
        $beat = Product::find($id);
        // If the resource doesn't exist, return an error response
        if (! $beat) {
            return response()->json([
                'message' => 'Resource not found.',
            ], 404);
        }

        $beat->delete();
        // Return a success response
        return response()->json([
            'message' => 'Resource deleted successfully.',
        ]);
    }    

    public function measurements(Request $request, $id)
    {
        $products    = Product::with('measurements')->with('inventory')->where('id',$id)->get()->first();

        return response()->json([
            'data'=>$products->measurements
        ]);        
    }    

    public function max_qty(Request $request, $id,$typeId)
    {
        $products    = Product::with('measurements')->with('inventory')->where('id',$id)->get()->first();        

        $total_stock = $products->inventory->total_stock;
        $buying_price = $products->inventory->buying_price; // Min rate

        $measurement = $products->measurements;
        $qty = collect($measurement)->filter(function($value) use ($typeId){
            return $value->id == $typeId;
        })->first()->quantity;

        return response()->json(
            [
                'max_qty'=>($total_stock/$qty),2,
                'min_rate'=>$buying_price
            ]
        );
        
    }
    
    
}
