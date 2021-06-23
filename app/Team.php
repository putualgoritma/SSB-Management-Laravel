<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'code',
        'name',
    ];
    public function student()
    {
    	return $this->hasOne('App\Student');
    }
}
