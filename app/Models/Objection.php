<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Objection extends Model
{
    use HasFactory;

    protected  $fillable = [
        'student_id',
        'exam_id',
        'subject_id',
        'message',
        'is_hidden'
    ];


    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exam()
    {
        return $this->belongsTo(ExameManages::class, 'exam_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    

    public function studentYearTwo()
    {
        return $this->belongsTo(StudentYearTwo::class  , 'student_id');
    }

}
