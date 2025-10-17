<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('reminder:daily-journal')->everyFourMinutes();

Schedule::command('students:check-absences')->everyFourMinutes();

Schedule::command('notify:missing-journals')->everyFourMinutes();
