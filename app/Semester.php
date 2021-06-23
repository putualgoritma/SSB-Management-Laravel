<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class semester extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];
    public function schedule(){
    	return $this->hasMany('App\Tag');
    }
}
