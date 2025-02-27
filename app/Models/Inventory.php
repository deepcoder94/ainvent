<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventory';

    protected $fillable = ["item_code","product_id","total_stock"];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}
