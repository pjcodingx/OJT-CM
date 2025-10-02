<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Journal;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Console\Command;
use App\Models\CompanyTimeOverride;

class NotifyMissingJournals extends Command
{
   protected $signature = 'notify:missing-journals';
    protected $description = 'Notify students if they have missing journals based on OJT schedule';

    public function handle()
    {
        $students = Student::with('company')->get();

        foreach ($students as $student) {
            $company = $student->company;
            if (!$company) continue;

            $startDate = Carbon::parse($company->default_start_date);
            $today = Carbon::today();

            $noWorkDates = CompanyTimeOverride::where('company_id', $company->id)
                                ->where('is_no_work', 1)
                                ->pluck('date')
                                ->toArray();

           $workingDays = json_decode($company->working_days, true) ?? [];
                $allowedDates = [];
                $current = $startDate->copy();
                while ($current->lte($today)) {
                    $dayName = $current->format('l'); // Monday, Tuesday...
                    if (in_array($dayName, $workingDays) && !in_array($current->toDateString(), $noWorkDates)) {
                        $allowedDates[] = $current->toDateString();
                    }
                    $current->addDay();
                }

            $submittedDates = Journal::where('student_id', $student->id)
                                ->pluck('journal_date')
                                ->toArray();

            $missedDates = array_diff($allowedDates, $submittedDates);

            if (!empty($missedDates)) {
                Notification::create([
                    'user_id' => $student->id,
                    'user_type' => 'student',
                    'title' => 'Missing Journal Submission',
                    'message' => 'You have not submitted journals for the following date(s): ' . implode(', ', $missedDates),
                    'type' => 'warning',
                    'is_read' => false,
                ]);
            }

             if ($student->faculty_id) {
                    Notification::create([
                        'user_id' => $student->faculty_id,
                        'user_type' => 'faculty',
                        'title' => 'Student Missing Journal Alert',
                        'message' => $student->name . ' has not submitted journals for: ' . implode(', ', $missedDates),
                        'type' => 'warning',
                        'is_read' => false,
                    ]);
                }
        }

        $this->info('Missing journal notifications sent successfully.');
    }
}
