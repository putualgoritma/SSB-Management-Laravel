<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'code',
        'register',
        'periode',
        'semester_id',
        'grade_id',
        'periode_id',
    ];
    function grade(){
        return $this->belongsTo('App\Grade');
    }
    public function absent(){
        return $this->belongsToMany('App\Absent');
    }
    function semester(){
        return $this->belongsTo('App\Semester');
    }
    function periode(){
        return $this->belongsTo('App\Periode');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'schedule_subjects', 'schedule_id', 'subject_id')
        ->withPivot([
            'teacher_id','start','end',
            ]);
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
