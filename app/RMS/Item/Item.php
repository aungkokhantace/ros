<?php

namespace App\RMS\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'items';
    protected $fillable = ['id','name','image','description','price','status','category_id','standard_cooking_time','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];


    public function category()
    {
        return $this->belongsTo('App\RMS\Category\Category', 'category_id', 'id');
    }

    public  function discount()
    {
        return $this->hasMany('App\RMS\Discount\DiscountModel');
    }

    public function favourite()
    {
        return $this->hasMany('App\RMS\Favourite\Favourite');
    }

    public function sub_item(){
        return $this->hasMany('App\RMS\sub_item\sub_item');
    }

    public function Orderdetail()
    {
        return $this->hasMany('App\RMS\Orderdetail\Orderdetail');
    }
}

