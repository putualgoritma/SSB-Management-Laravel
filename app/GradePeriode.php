<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GradePeriode extends Model
{
    protected $table = 'grade_periode';

    protected $fillable = [
        'grade_id',
        'periode_id',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id')->select('id', 'code', 'name');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id')->select('id', 'code', 'name', 'periode');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_grade_periode', 'grade_periode_id', 'student_id')
            ->select(['students.id', 'students.name']);
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
}
