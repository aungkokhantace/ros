<?php

namespace App\RMS\Category;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'category';

    protected $fillable=['id','name','parent_id','kitchen_id','image','status','description','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];


    public function item()
    {
       return $this->hasMany('App\RMS\Item\Item');
    }

    public function kitchen()
    {
        return $this->belongsTo('App\RMS\Kitchen\Kitchen', 'kitchen_id', 'id');
    }
}

