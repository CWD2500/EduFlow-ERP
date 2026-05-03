<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplementaryExams extends Model
{
    use HasFactory;


    protected $fillable = 
    [
        'student_id',
        'student_name',
        'specializations_id',
        'exam_id'
    ];


    public function exams()
    {
        return $this->belongsTo(ExameManages::class  , 'exam_id');
    }
}
