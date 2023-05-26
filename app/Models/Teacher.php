<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'mon',
        'tues',
        'wed',
        'thurs',
        'fri',
        'sat',
        'sun',
        'price',
        'stars',
        'comments',
    ];
}
