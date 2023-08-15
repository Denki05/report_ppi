<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCustomerTypeDetail extends Model
{
    use HasFactory;

    protected $table = 'report_type_detail';

    protected $fillable = [
        'report_type_detail_id',
        'product_name',
        'product_brand', 
        'product_qty', 
        'pakaging_name', 
        'factory_name',
    ];
}
