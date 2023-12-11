<?php


namespace App;


use Illuminate\Database\Eloquent\Model as BaseModel;


class Factory extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *	
     * @var array
     */
    protected $fillable = [
        'factory_name', 
    ];
    protected $table = 'tbl_factory';
}