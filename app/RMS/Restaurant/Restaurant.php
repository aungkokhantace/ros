<?php

namespace App\RMS\Restaurant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Restaurant extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'restaurant';

    protected $fillable=['id','name','logo','phone_no','email','address','status','description','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];


   
}

