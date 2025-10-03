<?php

namespace App\Http\Controllers\faculty;

use App\Models\Company;
use App\Models\Journal;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentRating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FacultyDashboardController extends Controller
{
    //
    public function dashboard(){

        $faculty = Auth::guard('faculty')->user();

        // Summary cards
        $journalCount = Journal::whereHas('student', fn($q) => $q->where('faculty_id', $faculty->id))->count();
        $totalStudents = Student::where('faculty_id', $faculty->id)->where('status', 1)->count();
        $feedbackTotal = StudentRating::whereHas('student', fn($q) => $q->where('faculty_id', $faculty->id))->count();

        // Students under this faculty
        $students = Student::where('faculty_id', $faculty->id)->get();

        // Overall progress %
        $totalAccumulated = $students->sum(fn($s) => $s->accumulated_hours);
        $totalRequired = $students->sum(fn($s) => $s->required_hours);
        $completionPercent = $totalRequired > 0 ? round(($totalAccumulated / $totalRequired) * 100, 1) : 0;

        // Detailed counts
        $completedCount = $students->filter(fn($s) => $s->hasCompletedOjt())->count();
        $partialCount = $students->filter(fn($s) => $s->accumulated_hours > 0 && !$s->hasCompletedOjt())->count();
        $notStartedCount = $students->filter(fn($s) => $s->accumulated_hours == 0)->count();

        $totalCompanies = Company::where('faculty_id', $faculty->id)->count();

        return view('faculty.dashboard', compact(
            'faculty', 'journalCount', 'totalStudents', 'feedbackTotal',
            'completionPercent', 'completedCount', 'partialCount', 'notStartedCount', 'totalCompanies'
        ));

    }
}
