<?php

namespace App\RMS\Promotion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promotion extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'promotions';
    protected $fillable = ['id','promotion_name','from_date','to_date','from_time','to_time','sell_item_qty',
        'present_item','present_item_qty','created_by','updated_by','deleted_by','created_at','updated_at','deleted_at'];

    public function items()
    {
      return $this->belongsTo('App\RMS\Item\Item', 'present_item', 'id');
    }

    public function sub_menu()
    {
        return $this->belongsTo('App\RMS\sub\Sub','set_id','id');
    }

}
