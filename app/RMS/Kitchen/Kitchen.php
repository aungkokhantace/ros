<?php

namespace App\RMS\Kitchen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kitchen extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'kitchen';
    protected $fillable = ['id','name','restaurant_id','branch_id','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

    public function category()
    {

        return $this->hasMany('App\RMS\Category\Category');
    }

    public function user()
    {

        return $this->hasMany('App\User');
    }

    public function branch()
    {

       return $this->belongsTo('App\RMS\Branch\Branch', 'branch_id', 'id');
    }
    public function restaurant()
    {

        return $this->belongsTo('App\RMS\Restaurant\Restaurant', 'restaurant_id', 'id');
    }

}
