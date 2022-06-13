<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'register',
        'schedule_id',
    ];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'session_teacher', 'session_id', 'teacher_id')
        ->withPivot([
            'position',
            ]);
    }

    public function schedules()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')
            ->with('subject')->with('grade_periode');
    }

    public function scopeFilterSessiRegister($query)
    {
        if(request()->input('register')!=""){
            $register = request()->input('register'); 

            return $query->where('register', $register);
        }else{
            return ;
        }
    }
}
