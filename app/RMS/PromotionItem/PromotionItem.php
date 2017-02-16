<?php

namespace App\RMS\PromotionItem;

use Illuminate\Database\Eloquent\Model;

class PromotionItem extends Model
{
    protected $table= 'promotion_items';
    protected $fillable = ['promotion_id','item_id','created_by','updated_by','deleted_by',
        'created_at','updated_at','deleted_at'];

    public function promotions()
    {
        return $this->belongsTo('App\RMS\Promotion\Promotion', 'promotion_id', 'id');
    }

    public function items()
    {
        return $this->belongsTo('App\RMS\Item\Item','item_id','id');
    }
}
