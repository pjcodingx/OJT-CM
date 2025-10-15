<?php

namespace App\Http\Controllers\student;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\OvertimeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OvertimeRequestController extends Controller
{
     public function store(Request $request)
    {
        $student = Auth::guard('student')->user();
        $today = Carbon::now()->toDateString();

        // 🛑 Check if the student already submitted an OT request today
        $existingRequest = OvertimeRequest::where('student_id', $student->id)
            ->where('date', $today)
            ->first();

        if ($existingRequest) {
            return back()->with('error', 'You have already submitted an overtime request for today.');
        }

        // ✅ Create new OT request (pending)
        OvertimeRequest::create([
            'student_id' => $student->id,
            'company_id' => $student->company_id,
            'date'       => $today,
            'status'     => 'pending',
        ]);

        return back()->with('success', 'Overtime request submitted and waiting for company approval.');
    }


   public function index()
    {
        $student = Auth::guard('student')->user();

        // Fetch all overtime requests of this logged-in student
        $requests = OvertimeRequest::where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('student.overtime.index', compact('requests', 'student'));
    }


     public function approve(Request $request, $id)
    {
        $request->validate([
            'scan_start' => 'required|date_format:H:i',
            'scan_end' => 'required|date_format:H:i|after:scan_start',
            'approved_hours' => 'required|numeric|min:0.5|max:8',
        ]);

        $ot = OvertimeRequest::findOrFail($id);
        $ot->update([
            'scan_start' => $request->scan_start,
            'scan_end' => $request->scan_end,
            'approved_hours' => $request->approved_hours,
            'status' => 'approved',
        ]);

        return back()->with('success', 'Overtime request approved.');
    }

     public function completeScan(Request $request)
    {
        $student = Auth::guard('student')->user();
        $now = Carbon::now();

        // Find today's approved OT
        $ot = OvertimeRequest::where('student_id', $student->id)
            ->where('date', $now->toDateString())
            ->where('status', 'approved')
            ->first();

        if (!$ot) {
            return back()->with('error', 'No approved overtime found for today.');
        }

        $scanStart = Carbon::createFromTimeString($ot->scan_start);
        $scanEnd = Carbon::createFromTimeString($ot->scan_end);

        // Check time validity
        if ($now->lessThan($scanStart)) {
            return back()->with('error', 'You cannot scan yet. Overtime period has not started.');
        }

        if ($now->greaterThan($scanEnd)) {
            return back()->with('error', 'Overtime scan period has ended.');
        }

        // Mark OT as completed
        $ot->update([
            'status' => 'completed',
        ]);

        // ✅ Add the approved OT hours to attendance record
        $attendance = Attendance::where('student_id', $student->id)
            ->where('date', $now->toDateString())
            ->first();

        if ($attendance) {
            $attendance->update([
                'time_out_counted' => $attendance->time_out_counted + $ot->approved_hours,
            ]);
        }

        return back()->with('success', 'Overtime completed successfully. Hours added to your record.');
    }


}
