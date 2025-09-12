<?php

namespace App\Http\Controllers\faculty;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FacultyAttendanceController extends Controller
{
    //
    public function logs(Request $request){
        $faculty = Auth::guard('faculty')->user();
         $startDate = $request->start_date;
            $endDate = $request->end_date;

    $attendances = Attendance::whereHas('student', function ($query) use ($faculty) {
            $query->where('faculty_id', $faculty->id)->where('status', 1);
        })
        ->when($startDate, fn($q) => $q->whereDate('date', '>=', $startDate))
        ->when($endDate, fn($q) => $q->whereDate('date', '<=', $endDate))
        ->with(['student.company'])
        ->orderByDesc('date')
        ->paginate(10);

    return view('faculty.attendance.logs', compact('attendances', 'startDate', 'endDate', 'faculty'));

    }
}
