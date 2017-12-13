<?php

namespace App\RMS\Activation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activation extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "tablet_activation";
    protected $fillable = ['id','tablet_id','activation_key','status','created_by',
    'updated_by','deleted_by','created_at','updated_at','deleted_at'];
}
