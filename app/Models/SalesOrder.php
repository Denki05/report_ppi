<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use HasFactory;

    protected $table = 'tbl_sales_invoice';

    protected $fillable = [
        'customer_id',
        'salesman_id',
        'invoice_date',
        'invoice_code',
        'invoice_subtotal', 
        'invoice_disc_amount', 
        'invoice_disc_amount2', 
        'invoice_grand_total', 
        'invoice_status', 
        'invoice_payment_type', 
        'invoice_product_type', 
        'invoice_exchange_rate', 
        'invoice_shipping_cost', 
        'invoice_cost_resi',
        'created_on',
        'updated_on',
        ''
    ];
}
