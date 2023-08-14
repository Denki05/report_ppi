<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportCustomerType extends Model
{
    use HasFactory;

    protected $table = 'report_type';

    protected $fillable = [
        'start_date',
        'end_date',
    ];
}
