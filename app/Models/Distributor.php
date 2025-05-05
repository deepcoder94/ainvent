<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    
    protected $fillable = ['name','address','gst_number','phone_number','dev_mode'];
}
