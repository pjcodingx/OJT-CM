<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password','photo','course_id', 'course', 'company_id', 'faculty_id', 'required_hours'
    ];

    //to get the time in and out and deduct in required hours

    public function getAccumulatedHoursAttribute(){ //!total hours based sa time in time out
     $totalSeconds = $this->attendances->reduce(function ($carry, $attendance) {
        if ($attendance->date && $attendance->time_in && $attendance->time_out) {
            $in = Carbon::parse($attendance->date . ' ' . $attendance->time_in);
            $out = Carbon::parse($attendance->date . ' ' . $attendance->time_out);

            $carry += abs($out->timestamp - $in->timestamp);
        }
        return $carry;
    }, 0);

    $hoursFromAttendance = $totalSeconds / 3600;

    // 2️⃣ Credited hours from approved appeals
    $hoursFromAppeals = $this->attendanceAppeals()
        ->where('status', 'approved')
        ->sum('credited_hours');

    // 3️⃣ Combine
    return round($hoursFromAttendance + $hoursFromAppeals, 2);
    }









    public function getRemainingHoursAttribute(){ //!get remaining hours
        return max($this->required_hours - $this->accumulated_hours, 0);
    }

        public function hasCompletedOjt(): bool
    {
        return $this->accumulated_hours >= $this->required_hours;
    }



    public function company(){
        return $this->belongsTo(Company::class);
    }

    public function faculty(){
        return $this->belongsTo(Faculty::class);
    }

    public function facultyAdviser()
{
    return $this->belongsTo(Faculty::class, 'faculty_id'); // adjust foreign key as per your schema
}


    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function journal(){
        return $this->hasMany(Journal::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function attendanceAppeals(){
        return $this->hasMany(AttendanceAppeal::class);
    }

    public function ratings()
    {
        return $this->hasMany(StudentRating::class);
    }




}
