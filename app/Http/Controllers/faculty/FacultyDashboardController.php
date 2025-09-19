<?php

namespace App\Http\Controllers\faculty;

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

        $journalCount = Journal::whereHas('student', function ($query) use ($faculty) {
                $query->where('faculty_id', $faculty->id);
            })->count();

            $totalStudents = Student::where('faculty_id', $faculty->id)->where('status', 1)->count();

              $feedbackTotal = StudentRating::whereHas('student', callback: function ($q) use ($faculty) {
                        $q->where('faculty_id', $faculty->id);
                    })->count();




    return view('faculty.dashboard', compact('faculty', 'journalCount', 'totalStudents', 'feedbackTotal'));



    }
}
