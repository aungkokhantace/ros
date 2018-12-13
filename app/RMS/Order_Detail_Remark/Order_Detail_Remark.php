<?php

namespace App\RMS\Order_detail_Remark;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_detail_Remark extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_detail_remark';
    protected $fillable = ['order_detail_id','remark_id','order_id','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];
}
