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

   public function index() {
    $studentId = Auth::guard('student')->id();

    // Get the student
    $student = Student::findOrFail($studentId);
    $company = $student->company;

    if (!$company) {
        $attendances = collect();
        $appeals = collect();
        return view('student.attendance-appeals.index', compact('appeals', 'attendances', 'student'));
    }

    // Ensure attendances exist for working days
    $student->ensureAttendancesExist();

    // Already submitted appeals
    $appeals = AttendanceAppeal::with('attendance')
                ->where('student_id', $studentId)
                ->latest()
                ->get();

    $appealedAttendanceIds = $appeals->pluck('attendance_id')->toArray();

    // Get attendances that can be appealed
    $attendances = $student->attendances()
        ->whereNotIn('id', $appealedAttendanceIds)
        ->get()
        ->filter(function ($attendance) use ($company) {

            $date = \Carbon\Carbon::parse($attendance->date);

            // Skip non-working days
            if (!$company->isWorkingDay($date)) return false;

            // Get override if exists for this date
            $override = $company->overrides()->whereDate('date', $date)->first();

            // Determine the effective time_out
            if ($override && $override->time_out_end) {
                $timeOut = \Carbon\Carbon::parse($date->toDateString() . ' ' . $override->time_out_end);
            } else {
                $timeOut = \Carbon\Carbon::parse($date->toDateString() . ' ' . $company->allowed_time_out_end);
            }

            // Only allow appeal if the time_out has passed
            if (\Carbon\Carbon::now()->lt($timeOut)) return false;

            // Appeal conditions: no time_in or no time_out
            return is_null($attendance->time_in) || is_null($attendance->time_out);
        });

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

    public function approve($appealId)
{
    // Find the appeal with its attendance and student
    $appeal = AttendanceAppeal::with(['attendance', 'student'])->findOrFail($appealId);

    // Mark the appeal as approved
    $appeal->status = 'approved';

    // If not already set, assign credited hours for this day (default 8 hours)
    if (!$appeal->credited_hours) {
        $appeal->credited_hours = 8; // adjust as per company policy
    }

    $appeal->save();

    // Update the attendance record
    $attendance = $appeal->attendance;

    // Notify the student
    Notification::create([
        'user_id' => $appeal->student_id,
        'user_type' => 'student',
        'type' => 'approve',
        'title' => 'Attendance Appeal Approved',
        'message' => "Your attendance appeal for {$attendance->date} was approved.",
        'is_read' => false,
    ]);

    // Optional: recalc total hours or absences (depends on your system)
    $student = $appeal->student;
    $student->load('attendances', 'attendanceAppeals'); // refresh relationships
    // Now $student->accumulated_hours and $student->calculateAbsences() will reflect approval

    return redirect()->back()->with('success', 'Attendance appeal approved and attendance updated.');
}


}
