<?php

namespace App\RMS\OrderSetMenuDetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderSetMenuDetail extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_setmenu_detail';
    protected $fillable = ['id','order_detail_id','setmenu_id','item_id','order_type_id','quantity','exception','order_time','order_duration','cooking_time','waiter_duration','waiter_id','waiter_status','status_id','cancel_status','message','remark','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];

    

}
