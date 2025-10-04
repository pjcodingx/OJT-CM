<?php

namespace App\Http\Controllers\company;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\CompanyTimeOverride;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyAttendanceController extends Controller
{
    //
    public function scanner(){
        $company = Auth::guard('company')->user();

        return view('company.attendance.scanner', compact('company'));
    }

public function scan(Request $request)
{
    try {
        // Validate QR input
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $student = Student::where('id', $request->qr_code)
                          ->where('status', 1)
                          ->first();

        if (!$student) {
            return response()->json([
                'success' => false,
                'name' => 'Unknown',
                'message' => 'Student not found.'
            ], 404);
        }

        $company = Auth::guard('company')->user();
        $today = Carbon::today();
        $now = Carbon::now();

        // Map Carbon dayOfWeek to day name
        $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $todayName = $dayNames[$today->dayOfWeek];

        // Check student assigned to company
        if ($student->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'name' => $student->name,
                'message' => 'This student is not assigned to your company.'
            ]);
        }

        // Default allowed times
        $timeInStart  = Carbon::parse($company->allowed_time_in_start ?? '00:00:00');
        $timeInEnd    = Carbon::parse($company->allowed_time_in_end ?? '23:59:59');
        $timeOutStart = Carbon::parse($company->allowed_time_out_start ?? '00:00:00');
        $timeOutEnd   = Carbon::parse($company->allowed_time_out_end ?? '23:59:59');

        // Decode working days
        $workingDays = json_decode($company->working_days ?? '["Monday","Tuesday","Wednesday","Thursday","Friday"]', true);

        // Fetch override for today
        $override = CompanyTimeOverride::where('company_id', $company->id)
                                       ->whereDate('date', $today)
                                       ->first();

        if ($override) {
            if ($override->is_no_work) {
                return response()->json([
                    'success' => false,
                    'name' => $student->name,
                    'message' => 'Today is a non-working day.'
                ]);
            }

            if ($override->time_in_start && $override->time_in_end) {
                $timeInStart = Carbon::parse($override->time_in_start);
                $timeInEnd   = Carbon::parse($override->time_in_end);
            }

            if ($override->time_out_start && $override->time_out_end) {
                $timeOutStart = Carbon::parse($override->time_out_start);
                $timeOutEnd   = Carbon::parse($override->time_out_end);
            }

            // Override allows attendance even if today is not in default working days
            $allowAttendance = true;
        } else {
            // No override → check default working days
            $allowAttendance = in_array($todayName, $workingDays);
        }

        if (!$allowAttendance) {
            return response()->json([
                'success' => false,
                'name' => $student->name,
                'message' => 'Today is a non-working day.'
            ]);
        }

        // Force times to today for accurate comparison
        $timeInStart  = Carbon::today()->setTimeFromTimeString($timeInStart->format('H:i:s'));
        $timeInEnd    = Carbon::today()->setTimeFromTimeString($timeInEnd->format('H:i:s'));
        $timeOutStart = Carbon::today()->setTimeFromTimeString($timeOutStart->format('H:i:s'));
        $timeOutEnd   = Carbon::today()->setTimeFromTimeString($timeOutEnd->format('H:i:s'));

        // Get today's attendance
        $attendance = Attendance::where('student_id', $student->id)
                                ->where('company_id', $company->id)
                                ->whereDate('date', $today)
                                ->first();

        // --- Time In ---
        if (!$attendance || !$attendance->time_in) {
            if ($now->between($timeInStart, $timeInEnd)) {
                if (!$attendance) {
                    $attendance = Attendance::create([
                        'student_id' => $student->id,
                        'company_id' => $company->id,
                        'time_in'    => $now,
                        'date'       => $today,
                    ]);
                } else {
                    $attendance->update(['time_in' => $now]);
                }

                return response()->json([
                    'success' => true,
                    'name' => $student->name,
                    'message' => 'Time In recorded successfully.'
                ]);
            }

            return response()->json([
                'success' => false,
                'name' => $student->name,
                'message' => 'Time In not allowed at this time.'
            ]);
        }

        // --- Time Out ---
        if (!$attendance->time_out) {
            if ($now->between($timeOutStart, $timeOutEnd)) {
                $attendance->update(['time_out' => $now]);

                return response()->json([
                    'success' => true,
                    'name' => $student->name,
                    'message' => 'Time Out recorded successfully.'
                ]);
            }

            return response()->json([
                'success' => false,
                'name' => $student->name,
                'message' => 'Time Out not allowed at this time.'
            ]);
        }

        // Already completed
        return response()->json([
            'success' => false,
            'name' => $student->name,
            'message' => 'Already completed attendance for today.'
        ]);

    } catch (\Exception $e) {
        Log::error('Scan error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'name' => 'Error',
            'message' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}












    public function logs(Request $request){
        $company = Auth::guard('company')->user();

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        //Kuhaon attendances of students
        $attendances = Attendance::whereHas('student', function ($query) use ($company){
            $query->where('company_id', $company->id)
            ->where('status',1);
        })->when($startDate, fn($q) => $q->whereDate('date', '>=' , $startDate))
            ->when($endDate, fn($q) => $q->whereDate('date', '<=' , $endDate))
            ->with('student')
            ->orderByDesc('date')
            ->paginate(10);

            return view('company.attendance.logs', compact('company', 'attendances', 'startDate', 'endDate'));
    }
}
