<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beat extends Model
{

    use SoftDeletes;
    protected $fillable = ['beat_name','beat_address','is_active'];
    
    public function payments(){
        return $this->hasMany(PaymentHistory::class,'beat_id');
    }
}
