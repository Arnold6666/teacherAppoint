<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Teacher;

class Curriculum extends Model
{
    use HasFactory;

    protected $table = 'curriculums';
    protected $primaryKey = 'id';
    protected $keytype = 'int';

    protected $fillable = [
        'uuid',
        'teacher_id',
        'student_id',
        'date',
        'time',
        'state_id',
        'price',
        'comment',
        'stars'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id');
    }
}
