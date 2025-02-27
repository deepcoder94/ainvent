<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return view('pages.products.list', ['currentPage' => 'products', 'products' => $products]);        
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
        try {
            $validated = $request->validate([
                'product_name'    => 'required|string|max:255',
                'product_rate' => 'required|numeric',
                'is_active'    => 'required',
            ]);

            $beat = Product::create([
                'product_name'    => $request->product_name,
                'product_rate' => $request->product_rate,
                'is_active'    => $request->is_active,
            ]);
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

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function updateProductById(Request $request,$id){
        try {
            $validated = $request->validate([
                'product_name'    => 'required|string|max:255',
                'product_rate' => 'required',
                'is_active'    => 'required',
            ]);
            $resource = Product::findOrFail($id);

            $beat = $resource->update([
                'product_name'    => $request->product_name,
                'product_rate' => $request->product_rate,
                'is_active'    => $request->is_active,
            ]);
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

    public function deleteProductById(Request $request, $id)
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
}
