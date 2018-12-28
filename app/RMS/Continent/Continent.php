<?php

namespace App\RMS\Continent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Continent extends Model
{
    use SoftDeletes;
    protected $table = 'continent';
    protected $guarded = [];

    public function category_continent()
    {
    	return $this->belongsToMany('App\RMS\Category\Category');
    }
}
