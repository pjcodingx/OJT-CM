<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Notification;
use Illuminate\Console\Command;

class CheckStudentAbsences extends Command
{
    protected $signature = 'students:check-absences';
    protected $description = 'Check students who did not time in today and mark them absent after company cutoff';
   public function handle()
    {
        $today = Carbon::today();

        $students = Student::with('company')->get();

        foreach ($students as $student) {
            if (!$student->company) continue;

            $company = $student->company;

            // Require start date
            if (!$company->default_start_date) continue;

            $startDate = Carbon::parse($company->default_start_date);

            // Skip absence check if today is before official start
            if ($today->lt($startDate)) {
                continue;
            }

            // If no cutoff is set, skip
            if (!$company->allowed_time_out_end) continue;

            $cutoff = Carbon::parse($company->allowed_time_out_end);

            // Only check if current time is past cutoff
            if (now()->lessThan($cutoff)) {
                continue;
            }

            // Check if student has attendance today
            $attendance = Attendance::where('student_id', $student->id)
                ->whereDate('time_in', $today) // safer than created_at
                ->first();

            if (!$attendance) {
                // No time in today -> absent
                Notification::create([
                    'user_id'   => $student->id,
                    'user_type' => 'student',
                    'title'     => 'Absence Alert',
                    'message'   => 'You did not time in today (' . $today->toFormattedDateString() . '). You have been marked absent.',
                    'type'      => 'absence',
                ]);

             if ($student->faculty_id) {
                    Notification::create([
                        'user_id'   => $student->faculty_id,
                        'user_type' => 'faculty',
                        'title'     => 'Student Absence Alert',
                        'message'   => $student->name . ' did not time in today (' . $today->toFormattedDateString() . ').',
                        'type'      => 'Absent',
                    ]);
                }
            }
        }

        $this->info('Absence check finished for ' . $today->toDateString());
    }

}
