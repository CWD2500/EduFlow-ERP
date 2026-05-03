<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    use HasFactory;

    protected $fillable = 
    [
        'user_id',
        'message',
        'is_read',
    ];

    public function  objection()
    {
        return $this->belongsTo(Objection::class , 'objection_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class , 'user_id' );
    }
}
