<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class periode extends Model
{
    protected $fillable = [
        'code',
        'name',
        'periode',
        'status',
    ];
    public function schedule(){
    	return $this->hasMany('App\Tag');
    }
}
