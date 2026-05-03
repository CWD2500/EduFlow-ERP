<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExameManages extends Model
{
    use HasFactory;


    protected $fillable = [
        'subject_id',
        'student_id',
        'specializations_id',
        'academic_year',
        'Supplementary_course',
        'degree_n',
        'degree_p',
        'exam_n',
        'exam_p',
        'student_number_id',
        'is_hidden',
        'semester'
        
        
      
    ];



    // علاقة الامتحان بالطلاب
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'student_id');
    }

    // علاقة الامتحان بالمواد الدراسية
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // علاقة الامتحان بالأقسام
    public function specialization()
    {
        return $this->belongsTo(Specialization::class, 'specializations_id');
    }

    // علاقة الامتحان بالاعتراضات
    public function objection()
    {
        return $this->hasMany(Objection::class, 'exam_id');
    }

    // علاقة الامتحان بالامتحانات التكميلية
    public function supplements()
    {
        return $this->hasMany(SupplementaryExams::class, 'exam_id');
    }

    // علاقة الامتحان بالطلاب للسنة الثانية
    public function studentYearTwo()
    {
        return $this->belongsTo(StudentYearTwo::class, 'student_id', 'student_id');
    }
     
}


