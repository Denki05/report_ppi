<?php


namespace App;


use Illuminate\Database\Eloquent\Model as BaseModel;


class Customer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'customer_store_code', 
        'customer_store_name', 
        'customer_store_address',
        'customer_zone', 
        'customer_province', 
        'customer_city', 
        'customer_type',
    ];
    protected $table = 'tbl_customer';
}