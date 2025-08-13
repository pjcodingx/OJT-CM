<?php

namespace App\Http\Controllers\student;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\AttendanceAppeal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AttendanceAppealController extends Controller
{
    //

    public function index(){
        $student = Auth::guard('student')->user();
  $student = Auth::guard('student')->user();
    $studentId = $student->id;


    $appeals = AttendanceAppeal::with('attendance')
        ->where('student_id', $studentId)
        ->latest()
        ->get();


    $appealedAttendanceIds = $appeals->pluck('attendance_id')->toArray();


    $attendances = Attendance::where('student_id', $studentId)
        ->whereNotIn('id', $appealedAttendanceIds)
        ->orderBy('date', 'desc') // or created_at/time_in depending on your schema
        ->limit(10)
        ->get();

    return view('student.attendance-appeals.index', compact('appeals', 'attendances', 'student'));
    }

    public function create($attendanceId){
           $studentId = Auth::guard('student')->id();

        $attendance = Attendance::where('student_id', $studentId)
            ->findOrFail($attendanceId);

        return view('student.attendance-appeals.create', compact('attendance'));
    }

    public function store(Request $request){

         $studentId = Auth::guard('student')->id();

        $request->validate([
            'attendance_id' => 'required|exists:attendances,id',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);


        $attendance = Attendance::where(    'student_id', $studentId)
            ->findOrFail($request->attendance_id);

        $path = null;
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attendance_attachments', 'public');
        }

        AttendanceAppeal::create([
            'attendance_id' => $attendance->id,
            'student_id' => $studentId,
            'reason' => $request->reason,
            'attachment' => $path,
            'status' => 'pending',
        ]);


                $student = Student::find($studentId);


                $company = $student->company;

        if ($company) {
                    Notification::create([
                        'user_id' => $company->id,
                        'user_type' => 'company',
                        'type' => 'appeal',
                        'title' => 'Attendance Appeal',
                        'message' => "New Attendance Appeal was submitted by {$student->name}.",

                        'is_read' => false,
                    ]);
                }

        return redirect()->route('student.attendance-appeals.index')
            ->with('success', 'Attendance appeal submitted successfully.');
    }

}
