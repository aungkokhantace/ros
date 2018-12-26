<?php

namespace App\RMS\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Config extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "config";
    protected $fillable = ['id','site_activation_key','tax','service','restaurant_id','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

     public function restaurant()
    {

       return $this->belongsTo('App\RMS\Restaurant\Restaurant', 'restaurant_id', 'id');
    }
}
