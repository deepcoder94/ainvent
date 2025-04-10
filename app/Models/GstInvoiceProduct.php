<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GstInvoiceProduct extends Model
{
    protected $table = 'gst_invoice_products';

    protected $fillable = ["gst_invoice_id","product_name","hsn_code","quantity","unit_price","taxable_amount","other_charges","total","gst_breakup"];
}