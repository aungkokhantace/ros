<?php

namespace App\RMS\Permission;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'permissions';

    protected $fillable = [
        'role_id',
        'module_id','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'

    ];

    public function roles()
    {
        return $this->belongsTo('App\RMS\Role\Role','role_id','id');
    }

    public function modules()
    {
        return $this->belongsTo('App\RMS\Module\Module','module_id','id');
    }
}
