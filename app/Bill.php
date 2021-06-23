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
        'student_id',
    ];
    public function student(){
        return $this->belongsTo('App\Student');
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
}
