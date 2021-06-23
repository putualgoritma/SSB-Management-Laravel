<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'code',
        'name',
        'alias',
        'place',
        'date',
        'address',
        'village',
        'district',
        'regency',
        'gender',
        'school',
        'gradeoriginal',
        'nisn',
        'religion',
        'email',
        'phone',
        'jerseynumber',
        'jerseysize',
        'fathername',
        'fatherjob',
        'fatherphone',
        'mothername',
        'motherjob',
        'motherphone',
        'photo',
        'familylist',
        'ijazah',
        'birthcertificate',
        'note',
        'position',
        'grade_id',
        'team_id',
        'register',
        'created_at',
        'updated_at',
    ];
    public function grade() { 
    return $this->belongsTo('App\Grade')->select('id', 'code', 'name'); 

    }
    public function team() { 
        return $this->belongsTo('App\Team'); 
    
        }
    public function test(){
        return $this->belongsToMany('App\Test');
    }
    public function absent(){
        return $this->belongsToMany('App\Absent');
    }
    public function bill(){
        return $this->hasOne('App\bill');
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
