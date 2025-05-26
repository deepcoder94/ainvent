<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['product_name','product_rate','is_active','product_hsn','gst_rate'];    
    public function measurements()
    {
        return $this->belongsToMany(Measurement::class, 'product_measurements', 'product_id', 'measurement_id');
    }
    public function inventory(){
        return $this->hasOne(Inventory::class,'product_id');
    }
}
