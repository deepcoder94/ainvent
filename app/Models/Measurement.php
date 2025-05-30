<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Measurement extends Model
{
    use SoftDeletes;
    protected $fillable = ['name','quantity'];
    // Define the many-to-many relationship with the Product model
    public function products()
    {
        // return $this->belongsToMany(Product::class, 'product_measurements', 'measurement_id', 'product_id');
        return $this->belongsToMany(Product::class, 'product_measurements', 'measurement_id', 'product_id');

    }    
}
