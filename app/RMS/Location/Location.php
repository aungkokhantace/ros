<?php

namespace App\RMS\Location;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'locations';
    protected $fillable = ['id','location_type','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

    public function table()
    {
        return $this->hasMany('App\RMS\Table\Table');
    }

}
