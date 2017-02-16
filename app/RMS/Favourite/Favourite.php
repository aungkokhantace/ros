<?php

namespace App\RMS\Favourite;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Favourite extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table='favourites';

    protected $fillable=['id','member_id','item_id'];

    public function member()
    {
        return $this->belongsTo('App\RMS\Member\Member','member_id','id','created_by','updated_by','deleted_by',
            'created_at','updated_at','deleted_at');
    }

    public function item()
    {
        return $this->belongsTo('App\RMS\Item\Item','item_id','id');
    }


}
