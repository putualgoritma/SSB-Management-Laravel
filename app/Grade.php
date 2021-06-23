<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'code',
        'name',
        'agemin',
        'agemax',
    ];
    public function student()
    {
    	return $this->hasOne('App\Student');
    }
    
    public function schedule(){
        return $this->hasMany('App\schedule');
    }
}
