<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCustomerType extends Model
{
    use HasFactory;

    protected $table = 'report_type';

    protected $fillable = [
        'customer_name',
        'customer_city',
        'customer_type', 
        'invoice_code', 
        'invoice_brand', 
        'invoice_date', 
        'invoice_subtotal', 
        'invoice_disc_amount', 
        'invoice_disc_amount2', 
    ];
}
