<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Console\Command;

class SendDailyJournalReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:send-daily-journal-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */


    protected $signature = 'reminder:daily-journal';
    protected $description = 'Send daily Journal submission reminder to all students';
    public function handle()
    {
           $today = Carbon::today();

        $students = Student::all();

        foreach ($students as $student) {
            $alreadySent = Notification::where('user_id', $student->id)
                ->where('type', 'journal-reminder')
                ->whereDate('created_at', $today)
                ->exists();

            if (!$alreadySent) {
                Notification::createLimited([
                    'user_id' => $student->id,
                    'user_type' => 'student',
                    'title'   => 'Daily Journal Reminder',
                    'message' => 'Please submit your journal for before on or before 11:59pm.',
                    'type'    => 'journal-reminder',
                    'is_read' => false,
                ]);
            }
        }

        $this->info('Daily journal reminders sent successfully.');
    }
}
