<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use App\Models\Notification;
use Carbon\Carbon;

class CheckStudentAbsences extends Command
{
    protected $signature = 'students:check-absences';
    protected $description = 'Check student absences and notify student, faculty, and company';

    public function handle()
    {
        $now = Carbon::now();
        $this->info('Running absence check at ' . $now);

        $students = Student::with('company', 'faculty', 'attendances')->get();

        foreach ($students as $student) {
            $company = $student->company;
            if (!$company || !$company->default_start_date) continue;

            $today = Carbon::today();

            // Ensure attendance exists
            $attendance = $student->attendanceForDate($today);

            // Skip if student has time_in or time_out
            $isAbsent = empty($attendance->time_in) && empty($attendance->time_out);
            if (!$isAbsent) {
                $this->info("Skipping {$student->name}: already timed in/out today");
                continue;
            }

            // Remove previous absence notifications for today
            Notification::where('type', 'absence')
                ->whereDate('created_at', $today)
                ->whereIn('user_id', [$student->id, $student->faculty_id, $company->id])
                ->delete();

            // Notify Student
            Notification::createLimited([
                'user_id'   => $student->id,
                'user_type' => 'student',
                'title'     => 'Absence Alert',
                'message'   => "You did not time in/out today ({$today->toFormattedDateString()}). You have been marked absent.",
                'type'      => 'absence',
                'is_read'   => false,
            ]);


            // Notify Faculty
            if ($student->faculty_id) {
                Notification::createLimited([
                    'user_id'   => $student->faculty_id,
                    'user_type' => 'faculty',
                    'title'     => 'Student Absence Alert',
                    'message'   => "{$student->name} did not time in/out today ({$today->toFormattedDateString()}).",
                    'type'      => 'absence',
                    'is_read'   => false,
                ]);

            }

            // Notify Company
            if ($company->id) {
                Notification::createLimited([
                    'user_id'   => $company->id,
                    'user_type' => 'company',
                    'title'     => 'Student Absence Alert',
                    'message'   => "{$student->name} did not time in/out today ({$today->toFormattedDateString()}).",
                    'type'      => 'absence',
                    'is_read'   => false,
                ]);

            }
        }

        $this->info('Absence check finished for ' . $today->toDateString());
    }
}
