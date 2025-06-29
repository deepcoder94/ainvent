<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceRequest extends Model
{
    use SoftDeletes;
    protected $fillable = ["customer_id","beat_id"];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function beat(){
        return $this->belongsTo(Beat::class,'beat_id');
    }

    public function products(){
        return $this->hasMany(InvoiceRequestProduct::class,'invoice_request_id');
    }


    public function invoiceproducts()
    {
        return $this->belongsToMany(Product::class, 'invoice_request_products', 'invoice_request_id', 'product_id')
                    ->withPivot('quantity', 'rate'); // Include pivot data like quantity and price
    }    

    public function invoicemeasurements()
    {
        return $this->belongsToMany(Measurement::class, 'invoice_request_products', 'invoice_request_id', 'measurement_id')
                    ->withPivot('quantity', 'rate'); // Include pivot data like quantity and price
    }    
}
