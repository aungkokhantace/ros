<?php

namespace App\RMS\BookingRoom;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingRoom extends Model
{
   
    protected $table = 'booking_room';

    protected $fillable = ['booking_id', 'room_id'];

    public function room()
    {
        return $this->belongsTo('App\RMS\Room\Room', 'room_id', 'id');
    }

   
}

