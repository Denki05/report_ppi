<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCustomerTypeDetail extends Model
{
    use HasFactory;

    protected $table = 'report_type_detail';

    protected $fillable = [
        'customer_report_type_id',
        'customer_name',
        'customer_type', 
        'customer_text_kota', 
        'invoice_code', 
        'invoice_brand', 
        'invoice_date', 
        'invoice_subtotal', 
        'invoice_disc_amount', 
        'invoice_disc_amount2', 
        'invoice_product', 
        'packaging_name', 
        'invoice_qty'
    ];
}
