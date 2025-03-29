<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    protected $fillable = ["invoice_id","product_id","rate","quantity","measurement_id","buying_price"];
    
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id');        
    }

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function measurement(){
        return $this->belongsTo(Measurement::class,'measurement_id');
    }

    public function inventory(){
        return $this->belongsTo(Inventory::class,'product_id');
    }
}
