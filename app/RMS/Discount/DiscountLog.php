<?php

namespace App\RMS\Discount;

use Illuminate\Database\Eloquent\Model;

// use Illuminate\Database\Eloquent\SoftDeletes;
class DiscountLog extends Model
{
    protected $table = "discount_log";
    protected $fillable = ['id', 'restaurant_id', 'branch_id', 'name', 'amount', 'type', 'start_date', 'end_date', 'item_id', 'created_by', 'updated_by', 'deleted_by',
        'created_at', 'updated_at', 'deleted_at'];

    public function item()
    {
        return $this->belongsTo('App\RMS\Item\Item', 'item_id', 'id');
    }

    public function created_user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function updated_user()
    {
        return $this->belongsTo('App\User', 'updated_by', 'id');
    }

    public function deleted_user()
    {
        return $this->belongsTo('App\User', 'deleted_by', 'id');
    }
}
