<?php

namespace App\RMS\Order;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'order';
    protected $casts = ['id'=> 'string'];
    protected $fillable = ['id','user_id','take_id','order_time','member_id','total_price','member_discount','service_amount','tax_amount','all_total_amount','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];

    public function User()
    {
    	return $this->belongsTo('App\User', 'user_id', 'id');
    }   

    public function tables()
    {
        return $this->belongsToMany('App\RMS\Table\Table');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\RMS\Room\Room');
    }

}
