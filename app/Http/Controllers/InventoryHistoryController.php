<?php

namespace App\Http\Controllers;

use App\Models\InventoryHistory;

use Illuminate\Http\Request;

class InventoryHistoryController extends Controller
{

    public function list(Request $request){
        $inventoryHistory = InventoryHistory::with('product')->orderBy('id','desc')->with('measurement')->get();
        return view('pages.inventory-history.list', ['currentPage' => 'inventoryHistory','inventoryHistory' => $inventoryHistory]);        
    }

    public function listWithPaginate(Request $request){
        $inventoryHistory = InventoryHistory::with('product')->orderBy('id','desc')->with('measurement')->get();
        return view('pages.inventory-history.list', ['currentPage' => 'inventoryHistory','inventoryHistory' => $inventoryHistory]);        
    }
}