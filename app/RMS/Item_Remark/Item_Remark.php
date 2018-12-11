<?php

namespace App\RMS\Item_Remark;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_Remark extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'item_remark';
    protected $fillable = ['item_id','remark_id','created_by','updated_by',
    'deleted_by','created_at','updated_at','deleted_at'];
}
