<?php

namespace App\RMS\BookingTable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingTable extends Model
{
   
    protected $table = 'booking_table';

    protected $fillable = ['booking_id', 'room_id'];

    public function room()
    {
        return $this->belongsTo('App\RMS\Room\Room', 'room_id', 'id');
    }

   
}

