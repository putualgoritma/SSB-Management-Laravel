<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule_subject extends Model
{
    protected $fillable = [
        'subject_id',
        'teacher_id',
        'start',
        'end',
       
    ];
    // public function teacher(){
    // 	return $this->hasMany('App\Teacher');
    // }
    // public function subject(){
    // 	return $this->hasMany('App\Subject');
    // }

    public function teachers()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id')->select('id', 'code', 'name');
    }

    public function subjects()
    {
        return $this->belongsTo(Subject::class, 'subject_id')->select('id', 'code', 'name');
    }

    public function scopeFilterPeriode($query)
    {
        if(request()->input('periode')!=""){
            $periode = request()->input('periode'); 

            return $query->where('periode_id', $periode);
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

    public function scopeFilterGrade($query)
    {
        if(request()->input('grade')!=""){
            $grade = request()->input('grade'); 

            return $query->where('grade_id', $grade);
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
