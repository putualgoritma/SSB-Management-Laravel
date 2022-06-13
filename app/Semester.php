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
        'status',
    ];
    public function schedule(){
    	return $this->hasMany('App\Tag');
    }
}
