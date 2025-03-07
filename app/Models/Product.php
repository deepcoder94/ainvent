<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_name','product_rate','is_active'];    
    public function measurements()
    {
        return $this->hasMany(ProductMeasurement::class, 'product_id');
    }
}
