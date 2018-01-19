<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    private $id;
    protected $table="users";
    protected $fillable = [
        'id','user_name','staff_id','password','role_id','kitchen_id','status','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getID(){
        return $this->id;
    }

    public function roles()
    {
        return $this->belongsTo('App\RMS\Role\Role','role_id','id');
    }

    public function session(){
        return $this->hasMany('App\Session\Session');
    }

    public function kitchen(){
        return $this->belongsTo('App\RMS\Kitchen\Kitchen','kitchen_id','id');
    }
}
