<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GstInvoice extends Model
{
    protected $table = 'gst_invoices';

    protected $fillable = ["supplier_details","receipent_details","invoice_number","invoice_date","gst_breakup","taxable_amount","discount","other_charges","round_off_amount","total_invoice_amount"];

    public function gst_invoice_products(){
        return $this->hasMany(GstInvoiceProduct::class,'gst_invoice_id');
    }
}