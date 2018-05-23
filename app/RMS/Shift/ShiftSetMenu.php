<?php

namespace App\RMS\Shift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftSetMenu extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'shift_setmenu';
    protected $fillable = ['id','shift_id','setmenu_id','status','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

}
