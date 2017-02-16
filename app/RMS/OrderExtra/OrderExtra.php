<?php

namespace App\RMS\OrderExtra;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderExtra extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_extra';
    protected $fillable = ['order_detail_id','extra_id','quantity','amount','created_by','updated_by','deleted_by',
        'created_at','updated_at','deleted_at'];

    public function order_details()
    {
        return $this->belongsTo('App\RMS\Order\Orderdetail', 'order_detail_id', 'id');
    }

    public function add_on()
    {
        return $this->belongsTo('App\RMS\Addon\Addon','extra_id','id');
    }
}
