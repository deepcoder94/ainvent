<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    protected $table = 'inventory_history';

    protected $fillable = ["product_id","measurement_id","stock_out_in","stock_action","buying_price"];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function measurement(){
        return $this->belongsTo(Measurement::class,'measurement_id');
    }
}
