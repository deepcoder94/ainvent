<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ["customer_id","beat_id","invoice_number"];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function beat(){
        return $this->belongsTo(Beat::class,'beat_id');
    }

    public function products(){
        return $this->hasMany(InvoiceProduct::class,'invoice_id');
    }


    public function invoiceproducts()
    {
        return $this->belongsToMany(Product::class, 'invoice_products', 'invoice_id', 'product_id')
                    ->withPivot('quantity', 'rate'); // Include pivot data like quantity and price
    }    

    public function invoicemeasurements()
    {
        return $this->belongsToMany(Measurement::class, 'invoice_products', 'invoice_id', 'measurement_id')
                    ->withPivot('quantity', 'rate'); // Include pivot data like quantity and price
    }    
}
