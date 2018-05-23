<?php

namespace App\RMS\Shift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftCategory extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'shift_category';
    protected $fillable = ['id','shift_id','category_id','status','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

    public function shift()
    {
   		return $this->belongsTo('App\RMS\Shift\Shift', 'shift_id', 'id');
	}

}
