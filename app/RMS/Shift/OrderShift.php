<?php

namespace App\RMS\Shift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderShift extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_shift';
    protected $fillable = ['id','day_code','shift_id','status','ordering','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

}
