<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absent extends Model
{
    protected $fillable = [
        'register',
        'session_id',
        'student_grade_periode_id',
        'presence',
        'description',
        'bill',
        'amount',
    ];
    function sessions(){
        return $this->belongsTo(Session::class, 'session_id')->with('schedules')->select('id','schedule_id');
    }
    function studentgradeperiodes(){
        return $this->belongsTo(StudentGradePeriode::class, 'student_grade_periode_id')->with('students')->select('id','student_id');
    }
}
