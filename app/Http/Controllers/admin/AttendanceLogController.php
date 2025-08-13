<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Faculty;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceLogController extends Controller
{
    //
    public function adminIndex(Request $request){
        $admin = Auth::guard('admin')->user();

        //? Mao ni ang ato gamiton ig search
        $query = Attendance::with(['student.company', 'student.course', 'student.faculty']);


    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->whereHas('student', function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%");
        });
    }

    //? FILTERS
    if ($request->filled('course_id')) {
        $courseId = $request->input('course_id');
        $query->whereHas('student.course', function ($q) use ($courseId) {
            $q->where('id', $courseId);
        });
    }


    if ($request->filled('faculty_id')) {
        $facultyId = $request->input('faculty_id');
        $query->whereHas('student.faculty', function ($q) use ($facultyId) {
            $q->where('id', $facultyId);
        });
    }


    if ($request->filled('start_date')) {
        $query->where('date', '>=', $request->input('start_date'));
    }

    if ($request->filled('end_date')) {
        $query->where('date', '<=', $request->input('end_date'));
    }

    $attendances = $query->orderBy('date', 'desc')->paginate(10);

    $courses = Course::orderBy('name')->get();
    $faculties = Faculty::orderBy('name')->get();

    return view('admin.attendance', [
        'attendances' => $attendances,
        'courses' => $courses,
        'faculties' => $faculties,
        'search' => $request->input('search'),
        'course_id' => $request->input('course_id'),
        'faculty_id' => $request->input('faculty_id'),
        'start_date' => $request->input('start_date'),
        'end_date' => $request->input('end_date'),
    ]);
}
}
