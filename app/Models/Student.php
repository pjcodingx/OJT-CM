<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory, Notifiable;


    protected $fillable = [
        'name', 'email', 'password','photo','course_id', 'course', 'company_id', 'faculty_id', 'required_hours', 'status', 'username',
    ];

    //to get the time in and out and deduct in required hours

  public function getAccumulatedHoursAttribute()
    {
        $totalSeconds = DB::table('attendances')
            ->where('student_id', $this->id)
            ->whereNotNull('time_in_counted')
            ->whereNotNull('time_out_counted')
            ->selectRaw('SUM(TIME_TO_SEC(time_out_counted) - TIME_TO_SEC(time_in_counted)) as total_seconds')
            ->value('total_seconds') ?? 0;

        // Subtract penalties
        $penaltySeconds = $this->attendances()
            ->sum('penalty_hours') * 3600;

        $totalSeconds -= $penaltySeconds;

        $hoursFromAttendance = $totalSeconds / 3600;

        $hoursFromAppeals = $this->attendanceAppeals()
                                ->where('status', 'approved')
                                ->sum('credited_hours');

        return round(max($hoursFromAttendance + $hoursFromAppeals, 0), 2);
    }





    public function getRemainingHoursAttribute(){
        return max($this->required_hours - $this->accumulated_hours, 0);
    }

        public function hasCompletedOjt(): bool
    {
        return $this->accumulated_hours >= $this->required_hours;
    }

    public function calculateAbsences()
{
    $company = $this->company;
    if (!$company) return 0;

    if (!$company->default_start_date) return 0;

    $startDate = Carbon::parse($company->default_start_date);
    $endDate = Carbon::today();

    $currentDate = $startDate->copy();
    $absences = 0;

    while ($currentDate->lte($endDate)) {
        if ($company->isWorkingDay($currentDate)) {

            // Check if attendance exists
            $attendance = $this->attendances()
                ->whereDate('date', $currentDate->toDateString())
                ->first();

            // Check if there’s an approved appeal for this date
            $hasApprovedAppeal = $this->attendanceAppeals()
                ->whereHas('attendance', function($q) use ($currentDate) {
                    $q->whereDate('date', $currentDate->toDateString());
                })
                ->where('status', 'approved')
                ->exists();

            if ((!$attendance || (!$attendance->time_in && !$attendance->time_out)) && !$hasApprovedAppeal) {
                $absences++;
            }
        }

        $currentDate->addDay();
    }

    return $absences;
}


        public function appealsCount()
    {
        return $this->appeals()->count();
    }

   // In Student.php


public function ensureAttendanceForDate($date)
    {
        $companyId = $this->company_id;

        // Make sure $date is a Carbon instance
        $date = Carbon::parse($date)->toDateString();

        // Check if attendance already exists
        $attendance = Attendance::where('student_id', $this->id)
                        ->whereDate('date', $date)
                        ->first();

        // If exists, just return it (so we can update time_in/out later)
        if ($attendance) {
            return $attendance;
        }

        // If not, create a new record with null times
        return Attendance::create([
            'student_id' => $this->id,
            'company_id' => $companyId,
            'date' => $date,
            'time_in' => null,
            'time_out' => null,
        ]);
    }



    public function ensureAttendancesExist()
        {
            $company = $this->company;

            if (!$company || !$company->default_start_date) {
                return;
            }

            $startDate = Carbon::parse($company->default_start_date);
            $endDate = Carbon::today();

            $currentDate = $startDate->copy();

            while ($currentDate->lte($endDate)) {

                // Skip if not a working day
                if (!$company->isWorkingDay($currentDate)) {
                    $currentDate->addDay();
                    continue;
                }

                // Create attendance if it doesn't exist
                $this->ensureAttendanceForDate($currentDate);

                $currentDate->addDay();
            }
    }


   public function attendanceForDate($date)
{
    return $this->attendances()->firstOrCreate(
        ['date' => $date],
        ['company_id' => $this->company_id, 'time_in' => null, 'time_out' => null]
    );
}






    //! relationships

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


    public function appeals()
    {
        return $this->hasMany(AttendanceAppeal::class);
    }





}
