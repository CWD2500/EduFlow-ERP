<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\SoftDeletes;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable ;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'specializations_id',
        'role',
        'semester',
        'subject_yeare',
        'subject_sep',
        'student_id',
        'specialization',
        'ratio',
        'father',
        'father_job',
        'mother',
        'place_and_number_of_registration',
        'place_of_birth',
        'place_Get_the_certificate',
        'total',
        'religion',
        'city',
        'gender',
        'language',
        'exam_session',
        'teacher',
        'family',
        'recruitment_division',
        'national_number',
        'date_of_birth',
        'mobile_phone_number',
        'landline_number',
        'detailed_address',
        'date_of_registration',
        'is_hidden',
    ];



    public function objection()
    {
        return $this->hasMany(Objection::class  , 'student_id');
    }

    public  function specializations()
    {
      return  $this->belongsTo(specialization::class , 'specializations_id');
        
    }


    public function  subjects()
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject', 'teacher_id', 'subject_id');
    }


   //  Exam Manage
    public function exames(){
        
        // return $this->hasMany(ExameManages::class , 'student_id');
        return $this->hasMany(ExameManages::class, 'student_id', 'student_id');

    }


    public function  StudentYearTwo()
    {
        return $this->hasMany(StudentYearTwo::class , 'student_id');
    }


    public function notifications()
    {
        return $this->hasMany(notification::class , 'user_id' );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
