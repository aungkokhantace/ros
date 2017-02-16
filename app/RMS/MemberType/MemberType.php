<?php

namespace App\RMS\MemberType;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberType extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='member_type';

    protected $fillable=['id','type','description','discount_amount','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function Member()
    {

        return $this->hasMany('App\RMS\Member\Member');
    }

}

