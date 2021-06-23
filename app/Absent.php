<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    protected $fillable = [
        'register',
        'student_id',
        'schedule_subject_id',
        'presence',
        'description',
        'bill',
        'amount',
    ];
    function schedulesubject(){
        //return $this->belongsTo('App\Schedule_subject');
        return $this->belongsTo(Schedule_subject::class, 'schedule_subject_id')->with('subjects')->select('id','subject_id');
    }
    function student(){
        return $this->belongsTo('App\Student')->select('id', 'code', 'name');
    }
}
