<?php

namespace App\RMS\Booking;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "booking";
    protected $fillable = ['id','customer_name','booking_date','from_time','to_time','capacity',
        'created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];
    
    public function booking_table()
    {
    	return $this->hasMany('App\RMS\BookingTable\BookingTable');
    }
    public function booking_room()
    {
    	return $this->hasMany('App\RMS\BookingRoom\BookingRoom');
    }
}
