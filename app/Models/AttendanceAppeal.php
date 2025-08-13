<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceAppeal extends Model
{
    //
    protected $fillable = [
        'attendance_id',
        'student_id',
        'reason',
        'attachment',
        'status',
        'reject_reason',
        'credited_hours',
    ];

    protected $casts = [
        'credited_hours' => 'decimal:2',
    ];

    public function attendance(){
        return $this->belongsTo(Attendance::class);
    }

    public function student(){
        return $this->belongsTo(Student::class, 'student_id');
    }




}
