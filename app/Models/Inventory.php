<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;
    
    protected $table = 'inventory';

    protected $fillable = ["item_code","product_id","total_stock","buying_price"];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

}
