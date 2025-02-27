<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['beat_id','customer_name','customer_address','customer_phone','customer_gst','is_active'];

    public function beat(){
        return $this->belongsTo(Beat::class, 'beat_id');
    }
}
