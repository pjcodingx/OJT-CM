<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password','course_id', 'course', 'company_id', 'faculty_id', 'required_hours'
    ];


    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
