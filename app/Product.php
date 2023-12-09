<?php


namespace App;


use Illuminate\Database\Eloquent\Model as BaseModel;


class Product extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'product_code', 'product_name', 'category_id', 'product_cost_price', 'product_sell_price'. 'product_gender'
    ];
    protected $table = 'tbl_product';
}