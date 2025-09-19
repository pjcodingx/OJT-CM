<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Faculty extends Authenticatable
{
    //
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password','status',
    ];

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function companies(){


       return $this->hasMany(Company::class, 'faculty_id');
    }



}
