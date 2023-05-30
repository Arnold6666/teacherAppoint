<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Curriculum;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';
    protected $primaryKey = 'id';
    protected $keytype = 'int';

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

    public function curriculums(){
        return $this->hasMany(Curriculum::class, 'teacher_id');
    }
}
