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
            return $this->belongsToMany(Faculty::class, 'faculty_id');
        }

        public function students(){
            return $this->hasMany(Student::class, 'company_id', 'id');
        }

        // public function timeOverrides()
        // {
        //     return $this->hasMany(CompanyTimeOverride::class);
        // }

        public function overrides() {
            return $this->hasMany(CompanyTimeOverride::class);
        }

        public function ratings()
        {
            return $this->hasMany(StudentRating::class);
        }

        // app/Models/Company.php
public function faculty()
{
    return $this->belongsTo(\App\Models\Faculty::class, 'faculty_id');
}







}
