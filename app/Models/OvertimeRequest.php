<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OvertimeRequest extends Model
{
       use HasFactory;

    protected $fillable = [
        'student_id',
        'company_id',
        'date',
        'scan_start',
        'scan_end',
        'approved_hours',
        'status',
    ];

    // Each overtime belongs to one student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Each overtime belongs to one company
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
