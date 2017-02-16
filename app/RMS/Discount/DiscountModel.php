<?php

namespace App\RMS\Discount;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class DiscountModel extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table="discount";
    protected $fillable=['id','name','amount','type','start_date','end_date','item_id','created_by','updated_by','deleted_by',
    'created_at','updated_at','deleted_at'];

    public function item()
    {
        return $this->belongsTo('App\RMS\Item\Item','item_id','id');
    }

}
