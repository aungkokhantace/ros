<?php

namespace App\RMS\Table;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table ="tables";

    protected $fillable = ['id','table_no','location_id','capacity','status','created_by','updated_by','deleted_by','created_at','updated_at',
    'deleted_at'];

    public function Order(){
        return $this->hasMany('App\RMS\Order\Order');
    }

    public function booking(){
        return $this->hasMany('App\RMS\Booking\Booking');
    }

    public function Location(){
        return $this->belongsTo('App\RMS\Location\Location');
    }

    public function Table(){
        return $this->hasMany('App\RMS\BookingTable\BookingTable');
    }
    
    public function orders()
    {
        return $this->belongsToMany('App\RMS\Order\Order','order_tables');
    }

}
