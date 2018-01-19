<?php

namespace App\RMS\Room;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "rooms";
    protected $fillable = ['id','room_name','capacity','room_charges','service','status','created_by',
    'updated_by','deleted_by','created_at','updated_at','deleted_at'];
}
