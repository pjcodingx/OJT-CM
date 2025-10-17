<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    use HasFactory;



    protected $fillable = [
        'student_id','company_id', 'date', 'time_in', 'time_out', 'time_in_counted', 'time_out_counted','time_in_photo', 'time_out_photo', 'overtime_photo'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }

    public function appeals()
{
    return $this->hasMany(AttendanceAppeal::class);
}
 public function company()
    {
        return $this->belongsTo(Company::class);
    }


}
