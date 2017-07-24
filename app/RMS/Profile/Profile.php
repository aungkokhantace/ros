<?php

namespace App\RMS\Profile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'restaurant_profiles';
    protected $fillable = ['id','restaurant_name','logo','website','phone','address','message','remark','created_by',
    'updated_by','deleted_by','created_at','updated_at','deleted_at'];
}
