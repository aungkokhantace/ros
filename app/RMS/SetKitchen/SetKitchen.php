<?php

namespace App\RMS\SetKitchen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetKitchen extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'set_kitchen';

    protected $fillable = ['id', 'set_id', 'kitchen_id','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function set_menu()
    {
        return $this->belongsTo('App\RMS\SetMenu\SetMenu', 'set_id', 'id');
    }

    public function kitchen()
    {
        return $this->belongsTo('App\RMS\Kitchen\Kitchen', 'kitchen_id', 'id');
    }
}

