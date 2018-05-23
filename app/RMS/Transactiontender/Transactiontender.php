<?php

namespace App\RMS\Transactiontender;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactiontender extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'transaction_tenders';

    protected $fillable = ['id','order_id','tender_id','qty','paid_amount','changed_amount','rounding_amount','status','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];
}
