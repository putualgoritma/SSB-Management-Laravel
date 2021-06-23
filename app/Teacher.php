<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'place',
        'date',
        'address',
        'gender',
        'email',
        'phone',
        'created_at',
        'updated_at',
    ];
    public function schedule(){
        return $this->hasMany('App\schedule');
    }
    function schedule_subject(){
            return $this->belongsTo('App\schedule_subject');
        }
}
