<?php

namespace App\RMS\Branch;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'branch';

    protected $fillable=['id','name','restaurant_id','status','description','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];
}
