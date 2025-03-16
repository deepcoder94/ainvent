<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
    protected $table = 'payment_history';

    protected $fillable = ['customer_id','invoice_id','amount','beat_id'];
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
    public function beat(){
        return $this->belongsTo(Beat::class,'beat_id');
    }    
}
