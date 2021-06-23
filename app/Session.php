<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'register',
        'schedule_id',
        'grade_periode_id',
    ];

    public function studentGradePeriode()
    {
        return $this->belongsTo(GradePeriode::class, 'grade_periode_id')
            ->with('students');
    }

    public function schedules()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id')
            ->with('subjects');
    }
}
