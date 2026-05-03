<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'name',
        'semester',
        'subject_sep',
        'year',
    ];


    
    public function objection()
    {
        return $this->hasMany(Objection::class  , 'subject_id');
    }


        // Many To Many 
        public function  specializations()
        {
            return $this->belongsToMany(Specialization::class, 'subject_specialization', 'subject_id', 'specialization_id');

        }



        public function  usersTeacher()
        {
            return $this->belongsToMany(User::class, 'teacher_subject', 'subject_id', 'teacher_id');
        }


        public function studentYearTwo()
        {
            return $this->belongsTo(Subject::class  , 'student_id' , 'student_id');
        }
    


    
    
        //  Exam Manage
    public function exames(){
        
        return $this->hasMany(ExameManages::class , 'subject_id' );
    }

}

