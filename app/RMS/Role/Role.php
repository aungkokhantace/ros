<?php

namespace App\RMS\Role;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description','created_by','updated_by','deleted_by',
        'created_at','updated_at','deleted_at'
    ];

    public function user()
    {
        return $this->hasMany('App\User');
    }
    public function permissions()
    {
        return $this->hasMany('App\RMS\Permission\Permission');
    }
}
