<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $fillable = ["invoice_id"];

    public function invoice(){
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
