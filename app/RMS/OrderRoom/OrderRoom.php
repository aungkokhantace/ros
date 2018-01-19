<?php

namespace App\RMS\OrderRoom;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderRoom extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_room';
    protected $fillable = ['id','order_id','room_id',
        'created_at','updated_at','deleted_at'];

    
}
