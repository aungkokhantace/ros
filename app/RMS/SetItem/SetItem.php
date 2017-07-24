<?php

namespace App\RMS\SetItem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SetItem extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = 'set_item';

    protected $fillable = ['id', 'set_menu_id', 'item_id','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function set_item()
    {
        return $this->belongsTo('App\RMS\SetMenu\SetMenu', 'set_menu_id', 'id');
    }

    public function Item()
    {
        return $this->belongsTo('App\RMS\Item\Item', 'item_id', 'id');
    }
}

