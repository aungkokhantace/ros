<?php

namespace App\RMS\SetMenu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetMenu extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table="set_menu";
    protected $fillable=['set_menus_name','set_menus_price','image','status','status','kitchen_id','branch_id','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function set_item()
    {
        return $this->hasMany('App\RMS\SetItem\SetItem');
    }

     public function branch()
    {

       return $this->belongsTo('App\RMS\Branch\Branch', 'branch_id', 'id');
    }
}






