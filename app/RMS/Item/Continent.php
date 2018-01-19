<?php

namespace App\RMS\Item;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Continent extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'continent';
    protected $fillable = ['id','name','description','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];

    public function items()
    {
        return $this->hasMany('App\RMS\Item\Item');
    }
}

