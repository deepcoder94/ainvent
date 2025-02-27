<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Product;
use App\Models\Measurement;

use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventory = Inventory::with('product')->orderBy('id','desc')->get();
        $products = Product::get();
        $measurements = Measurement::get();
        return view('pages.inventory.list', ['currentPage' => 'inventory','inventory' => $inventory, 'products' => $products,'measurements' => $measurements]);        
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
        try{
            $records = $request->input('records');
            foreach ($records as $record){
                $product_id = $record['inv_product'];
                // Get product from inventory if exists
    
                $product = Inventory::where('product_id', $product_id)->get()->first();
                $mea_qty = Measurement::where('id', (int)$record['inv_mea'])->first()->quantity;
                $total_qty = (int)$record['inv_qty'] * $mea_qty;
                if(!empty($product)){
                    // If product exists, increase the quantity

                    
                    $product->total_stock += $total_qty;
                    $product->save();

                    InventoryHistory::create([
                        'product_id' => (int)$product_id,
                        'measurement_id' => (int)$record['inv_mea'],
                        'stock_out_in'   => (int)$record['inv_qty'],
                        'stock_action'  => 'add'
                    ]);

                }
                else{
                    $invtry = Inventory::create([
                        'item_code'=>'',
                        'product_id' => (int)$product_id,
                        'total_stock' => $total_qty
                    ]);
                    $invtry->item_code = 'IN-'.$invtry->id;
                    $invtry->save();

                    InventoryHistory::create([
                        'product_id' => (int)$product_id,
                        'measurement_id' => (int)$record['inv_mea'],
                        'stock_out_in'   => (int)$record['inv_qty'],
                        'stock_action'  => 'add'
                    ]);

                }
            }
            $success = true;
            $message = 'Inventory saved successfully';            
        }
        catch(\Exception $e){
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
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        //
    }

    public function inventoryHistory(Request $request){
        $inventoryHistory = InventoryHistory::with('product')->orderBy('id','desc')->with('measurement')->get();
        return view('pages.inventory.history', ['currentPage' => 'inventoryHistory','inventoryHistory' => $inventoryHistory]);        
    }
}
