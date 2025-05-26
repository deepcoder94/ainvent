<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['beat_id','customer_name','customer_address','customer_phone','customer_gst','is_active'];

    public function beat(){
        return $this->belongsTo(Beat::class, 'beat_id');
    }

    public function payments(){
        return $this->hasOne(CustomerPayment::class);
    }
}
