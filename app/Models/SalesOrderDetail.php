<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesOrderDetail extends Model
{
    use HasFactory;

    protected $table = 'tbl_sales_invoice_item';

    protected $fillable = [ 
        'invoice_id',
        'product_id',
        'packaging_id',
        'invoice_item_qty',
        'invoice_item_disc_amount', 
        'invoice_item_disc_amount2', 
        'invoice_item_price', 
        'invoice_item_row_total',
    ];
}
