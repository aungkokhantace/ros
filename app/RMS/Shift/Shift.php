<?php

namespace App\RMS\Shift;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'shift';
    protected $fillable = ['id','name','description','status','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

    public function Category()
    {
   		return $this->hasMany('App\RMS\Shift\ShiftCategory');
	}

	public function User()
    {
   		return $this->hasMany('App\RMS\Shift\ShiftUser');
	}

}
