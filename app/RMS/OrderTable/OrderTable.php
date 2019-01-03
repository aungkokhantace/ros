<?php

namespace App\RMS\OrderTable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderTable extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table= 'order_tables';
    protected $fillable = ['id','order_id','table_id',
        'created_at','updated_at','deleted_at'];

    public function table(){
        return $this->belongsTo('App\RMS\Table\Table');
    }
    
}
