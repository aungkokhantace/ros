<?php

namespace App\RMS\SyncsTable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SyncsTable extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $table = "syncs_tables";
    protected $fillable = ['id','table_name','version','active','created_by','updated_by','deleted_by','created_at',
    'updated_at','deleted_at'];


}
