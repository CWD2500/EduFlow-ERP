<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];


    public function users()
    {
       return  $this->hasMany(User::class , 'specializations_id');
    }

    // Many To Many 
    public function subjects()
    {
        // return $this->belongsToMany(Subject::class , 'subject_specialization'  , 'specialization_id' , 'subject_id');
        return $this->belongsToMany(Subject::class, 'subject_specialization', 'specialization_id', 'subject_id');

    }


    // Exame Manage 
    public function exames(){
        return $this->hasMany(ExameManages::class , 'specializations_id');
    }

  
}



