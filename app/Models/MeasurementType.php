<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MeasurementType extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['type','is_active'];
}
