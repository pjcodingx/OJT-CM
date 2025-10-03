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
        $now = Carbon::now();

        // Load students with their company
        $students = Student::with('company.overrides')->get();

        foreach ($students as $student) {
            $company = $student->company;
            if (!$company) continue;

            // Skip if today is before company's start date
            if (!$company->default_start_date) continue;
            $startDate = Carbon::parse($company->default_start_date);
            if ($today->lt($startDate)) continue;

            // Check if there is an override for today
            $override = $company->overrides->firstWhere('date', $today->toDateString());

            // Skip if it's a no-work day
            if ($override && $override->is_no_work) continue;

            // Skip if today is not a working day (default schedule)
            if (!$company->isWorkingDay($today)) continue;

            // Determine cutoff time: override takes priority
            if ($override && $override->time_out_end) {
                $cutoff = Carbon::parse($today->toDateString() . ' ' . $override->time_out_end);
            } else if ($company->allowed_time_out_end) {
                $cutoff = Carbon::parse($today->toDateString() . ' ' . $company->allowed_time_out_end);
            } else {
                // No cutoff set, skip this company
                continue;
            }

            // Only check if current time is past cutoff
            if ($now->lt($cutoff)) continue;

            // Ensure attendance record exists
            $attendance = Attendance::firstOrCreate(
                [
                    'student_id' => $student->id,
                    'date'       => $today->toDateString(),
                ],
                [
                    'company_id' => $company->id,
                    'time_in'    => null,
                    'time_out'   => null,
                ]
            );

            // Only notify if student did not time in
            if (is_null($attendance->time_in)) {
                // Student notification
                Notification::create([
                    'user_id'   => $student->id,
                    'user_type' => 'student',
                    'title'     => 'Absence Alert',
                    'message'   => 'You did not time in today (' . $today->toFormattedDateString() . '). You have been marked absent.',
                    'type'      => 'absence',
                    'is_read'   => false,
                ]);

                // Faculty notification
                if ($student->faculty_id) {
                    Notification::create([
                        'user_id'   => $student->faculty_id,
                        'user_type' => 'faculty',
                        'title'     => 'Student Absence Alert',
                        'message'   => $student->name . ' did not time in today (' . $today->toFormattedDateString() . ').',
                        'type'      => 'Absent',
                        'is_read'   => false,
                    ]);
                }
            }
        }

        $this->info('Absence check finished for ' . $today->toDateString());
    }

}
