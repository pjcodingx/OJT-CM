<?php

namespace App\Http\Controllers\student;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentAttendanceController extends Controller
{
    //

    public function index(Request $request){
        $student = Auth::guard('student')->user();
        $query = Attendance::where('student_id', $student->id);

        if($request->has('date') && $request->date){
            $query->whereDate('date', $request->date);
        }

        $attendances = $query->orderBy('date', 'desc')->paginate(10);

        return view('student.attendance.index', compact('attendances',  'student'));

    }
}
