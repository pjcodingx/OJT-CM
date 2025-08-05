<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Company extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'photo', 'address', 'location', 'faculty_id'
    ];

        public function faculties()
        {
            return $this->belongsToMany(Faculty::class, 'company_faculty');
        }

        public function students(){
            return $this->hasMany(Student::class);
        }



}
