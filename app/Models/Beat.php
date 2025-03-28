<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beat extends Model
{
    protected $fillable = ['beat_name','beat_address','is_active'];
    
    public function payments(){
        return $this->hasMany(PaymentHistory::class,'beat_id');
    }
}
