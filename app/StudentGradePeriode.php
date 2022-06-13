<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGradePeriode extends Model
{
    protected $table = 'student_grade_periode';

    protected $fillable = [
        'student_id',
        'grade_periode_id',       
    ];    

    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id')->select('id', 'code', 'name');
    }

    function grade_periode(){
        return $this->belongsTo(GradePeriode::class, 'grade_periode_id')->with('periode')->with('grade');
    }
    
}
