<?php

namespace App\RMS\Remark;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remark extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "remark";
    protected $fillable = ['id','name','remark_code','description','status','created_by',
    'updated_by','deleted_by','created_at','updated_at','deleted_at'];
}
