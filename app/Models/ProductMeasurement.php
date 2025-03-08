<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMeasurement extends Model
{
    protected $table = 'product_measurements';

    protected $fillable = ['product_id','measurement_id'];  
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
