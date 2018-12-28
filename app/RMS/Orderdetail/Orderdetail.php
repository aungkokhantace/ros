<?php

namespace App\RMS\Orderdetail;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orderdetail extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_details';
    protected $fillable = ['id','order_detail_id','order_id','item_id','order_type_id','setmenu_id','exception','amount','discount_id','discount_amount','promotion_id','amount_with_discount','order_duration','cooking_time',
        'waiter_duration','waiter_id','status_id','message','remark','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function Order()
    {
        return $this->belongsTo('App\RMS\Order\Order', 'order_id', 'id');
    }

    public function Extra()
    {
        return $this->belongsTo('App\RMS\Extra\ExtraModel','extra','id');
    }

    public function Item()
    {
        return $this->belongsTo('App\RMS\Item\Item','item_id','id');
    }

    public function OrderExtras()
    {
        return $this->hasMany('App\RMS\OrderExtra\OrderExtra','order_detail_id','id');        
    }
}
