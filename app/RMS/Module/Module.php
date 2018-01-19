<?php

namespace App\RMS\Module;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'modules';
    protected $fillable = ['id','module'];

    public function permissions()
    {
        return $this->hasMany('App\RMS\Permission\Permission');
    }
}
