<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'student_id', 'date', 'time_in', 'time_out'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function appeals()
{
    return $this->hasMany(AttendanceAppeal::class);
}

}
