<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRating extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'student_id', 'company_id', 'rating', 'feedback'
    ];




    public function student(){
        return $this->belongsTo(Student::class);
    }

     public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
