<?php

namespace App\RMS\Payment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'payment';

    protected $fillable=['id','paid_amount','change_amount','rounding_amount','order_id','payment_type','payment_card_id','uuid','status','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];
}
