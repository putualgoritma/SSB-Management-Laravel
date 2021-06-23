<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class School extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'periode_active',
        'semester_active',
    ];
}
