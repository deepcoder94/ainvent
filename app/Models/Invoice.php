<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ["customer_id","beat_id"];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function beat(){
        return $this->belongsTo(Beat::class,'beat_id');
    }

    public function products(){
        return $this->hasMany(InvoiceProduct::class,'invoice_id');
    }
}
