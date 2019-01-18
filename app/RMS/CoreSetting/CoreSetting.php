<?php
namespace App\RMS\CoreSetting;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CoreSetting extends Model
{
    protected $table = 'core_settings';

    protected $fillable = [
      'code', 'type', 'value', 'description'
    ];

    protected $hidden = ['deleted_at'];
}
