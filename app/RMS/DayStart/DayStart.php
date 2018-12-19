<?php

namespace App\RMS\DayStart;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DayStart extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_day';
    protected $fillable = ['id','day_code','start_date','status','restaurant_id','branch_id','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

    public function branch(){
       return $this->belongsTo('App\RMS\Branch\Branch', 'branch_id', 'id');
    }
     public function restaurant(){
       return $this->belongsTo('App\RMS\Restaurant\Restaurant', 'restaurant_id', 'id');
    }

}
