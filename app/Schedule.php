<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'code',
        'register',
        'semester_id',
        'grade_periode_id',
        'subject_id',
        'end',
        'start',
    ];
    function grade_periode(){
        return $this->belongsTo(GradePeriode::class, 'grade_periode_id')->with('periode')->with('grade');
    }
    public function session(){
        return $this->belongsToMany('App\Session');
    }
    function semester(){
        return $this->belongsTo('App\Semester');
    }
    function subject(){
        return $this->belongsTo('App\Subject');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'schedule_teacher', 'schedule_id', 'teacher_id')
        ->withPivot([
            'position',
            ]);
    }

    public function scopeFilterSubject($query)
    {
        if(request()->input('subject')!=""){
            $subject = request()->input('subject'); 

            return $query->where('subject_id', $subject);
        }else{
            return ;
        }
    }

    public function scopeFilterSemester($query)
    {
        if(request()->input('semester')!=""){
            $semester = request()->input('semester'); 

            return $query->where('semester_id', $semester);
        }else{
            return ;
        }
    }

    public function scopeFilterGradePeriode($query)
    {
        if(request()->input('grade_periode_id')!=""){
            $grade_periode_id = request()->input('grade_periode_id'); 

            return $query->where('grade_periode_id', $grade_periode_id);
        }else{
            return ;
        }
    }

    public function scopeFilterRegister($query)
    {
        if(request()->input('register')!=""){
            $register = request()->input('register'); 

            return $query->where('register', $register);
        }else{
            return ;
        }
    }
}
