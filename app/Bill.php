<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'code',
        'periode',
        'register',
        'amount',
        'status',
        'student_grade_periode_id',
    ];
    public function studentgradeperiodes(){
        return $this->belongsTo(StudentGradePeriode::class, 'student_grade_periode_id')->with('students')->select('id','student_id');
    }
}
