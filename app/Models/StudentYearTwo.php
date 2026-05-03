<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentYearTwo extends Model
{
    use HasFactory;


    protected  $fillable = [
        'student_id',
        'specializations_id',
        'year_one_student',
        'student_name'
    ];


    public function users()
    {
        return $this->belongsTo(User::class , 'student_id' , 'student_id');
    }

    

    public function objection()
    {
        return $this->hasMany(Objection::class  , 'student_id');
    }


    
   
    public function  subjects()
    {
        return $this->belongsTo(Subject::class,  'subject_id', 'subject_id');
    }


    public function exameManages()
    {
        return $this->hasMany(ExameManages::class, 'student_id', 'student_id');
    }


 
   
}
