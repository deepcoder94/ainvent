<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPayment extends Model
{
    protected $fillable = ['customer_id','total_due','invoice_total'];

    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}