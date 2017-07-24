<?php

namespace App\RMS\Pricehistory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pricehistory extends Model
{
    use SoftDeletes;

    protected $table= 'setup_price_tracking';
    protected $fillable = ['id','table_name','table_id','table_id_type','action','old_price','new_price','created_by','updated_by',
        'deleted_by','created_at','updated_at','deleted_at'];
}
