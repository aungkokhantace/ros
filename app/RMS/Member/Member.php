<?php

namespace App\RMS\Member;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'members';

    protected $fillable = ['id','name','email','phone','birthdate','member_type_id','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function member_type(){
        return $this->belongsTo('App\RMS\MemberType\MemberType','member_type_id','id');
    }

    public function favourite()
    {
        return $this->hasMany('App\RMS\Favourite\Favourite');
    }
}
