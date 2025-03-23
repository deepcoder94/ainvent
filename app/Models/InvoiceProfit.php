<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceProfit extends Model
{
    protected $fillable = ["invoice_number","invoice_id","gst_invoice_id","is_gst_invoice","profit_amount"];

}
