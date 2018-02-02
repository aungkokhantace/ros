<?php

namespace App\RMS\DayStart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayStart extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'day_start';
    protected $fillable = ['id','day_code','start_date','status','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

}
