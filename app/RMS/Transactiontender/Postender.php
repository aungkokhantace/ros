<?php

namespace App\RMS\Transactiontender;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postender extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'pos_tenders';

    protected $fillable = ['id','code','name','description','amount','card_type','status','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];
}
