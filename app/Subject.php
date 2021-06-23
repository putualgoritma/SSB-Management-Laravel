<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];
    public function test(){
        return $this->belongsToMany('App\Test');
    }
    // public function schedule(){
    //     return $this->hasMany('App\schedule');
    // }
    function schedule_subject(){
        return $this->belongsTo('App\schedule_subject');
    }
     public function schedule(){
        return $this->belongsToMany('App\schedule');
    }
}
