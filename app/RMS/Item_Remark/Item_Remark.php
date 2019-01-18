<?php

namespace App\RMS\Item_Remark;

use Illuminate\Database\Eloquent\Model;

class Item_Remark extends Model
{
    protected $dates = ['deleted_at'];
    protected $table= 'item_remark';
    protected $fillable = ['item_id','remark_id','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];
}
