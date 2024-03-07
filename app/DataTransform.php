<?php

namespace App;

use Illuminate\Database\Eloquent\Model as BaseModel;

class DataTransform extends BaseModel
{
    protected $table = 'tbl_data_sync2';
    protected $fillable =[
        'customer_name',
        'customer_type', 
        'customer_city', 
        'customer_provinsi',
        'customer_zone', 
        'invoice_code', 
        'invoice_date', 
        'invoice_brand', 
        'invoice_type', 
        'invoice_qty', 
        'invoice_purchase', 
        'invoice_disc_amount', 
        'invoice_disc_amount2',
        'invoice_shipp_cost', 
        'invoice_resi',
    ];
}