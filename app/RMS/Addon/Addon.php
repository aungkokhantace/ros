<?php

namespace App\RMS\Addon;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Addon extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'add_on';

    protected $fillable=['id','food_name','category_id','description','image','price','status','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];

    public function order_detail()
    {
        return $this->hasMany('App\OrderExtra\OrderExtra');
    }
}
