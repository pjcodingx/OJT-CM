<?php

namespace App\Http\Controllers\company;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $dayNames = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
        $todayName = $dayNames[$today->dayOfWeek];

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

        $workingDays = json_decode($company->working_days ?? '["Monday","Tuesday","Wednesday","Thursday","Friday"]', true);

        // Check for overrides
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

            $allowAttendance = true;
        } else {
            $allowAttendance = in_array($todayName, $workingDays);
        }

        if (!$allowAttendance) {
            return response()->json([
                'success' => false,
                'name' => $student->name,
                'message' => 'Today is a non-working day.'
            ]);
        }

        // Adjust times to today (Carbon objects)
        $timeInStart->setDate($today->year, $today->month, $today->day);
        $timeInEnd->setDate($today->year, $today->month, $today->day);
        $timeOutStart->setDate($today->year, $today->month, $today->day);
        $timeOutEnd->setDate($today->year, $today->month, $today->day);

        // Get or create today's attendance
        $attendance = Attendance::firstOrCreate(
            ['student_id' => $student->id, 'company_id' => $company->id, 'date' => $today],
            ['time_in' => null, 'time_out' => null]
        );

        // --- TIME IN ---
        if (!$attendance->time_in) {
            if ($now->lt($timeInStart)) {
                return response()->json(['success' => false, 'name' => $student->name, 'message' => 'Too early to Time In.']);
            }

            if ($now->gt($timeInEnd)) {
                return response()->json(['success' => false, 'name' => $student->name, 'message' => 'Time In window has ended.']);
            }

            $attendance->update([
                'time_in'         => $now,
                'time_in_counted' => $timeInEnd->toTimeString(),
            ]);

            return response()->json(['success' => true, 'name' => $student->name, 'message' => "Time In recorded successfully!"]);
        }

        // --- TIME OUT ---
        if (!$attendance->time_out) {
            if ($now->lt($timeOutStart)) {
                return response()->json(['success' => false, 'name' => $student->name, 'message' => 'Too early to Time Out.']);
            }

            if ($now->gt($timeOutEnd)) {
                return response()->json(['success' => false, 'name' => $student->name, 'message' => 'Time Out window has ended.']);
            }

            $attendance->update([
                'time_out'         => $now,
                'time_out_counted' => $timeOutStart->toTimeString(),
            ]);

            // Total hours in seconds
            $totalSeconds = DB::table('attendances')
                ->where('id', $attendance->id)
                ->selectRaw('TIME_TO_SEC(time_out_counted) - TIME_TO_SEC(time_in_counted) as total_seconds')
                ->value('total_seconds') ?? 0;

            // Subtract penalty hours
            $totalSeconds -= ($attendance->penalty_hours ?? 0) * 3600;

            $attendance->update(['total_hours' => round($totalSeconds / 3600, 2)]);

            return response()->json(['success' => true, 'name' => $student->name, 'message' => 'Time Out recorded successfully (based on schedule).']);
        }

        return response()->json(['success' => false, 'name' => $student->name, 'message' => 'Already completed attendance for today.']);

    } catch (\Exception $e) {
        Log::error('Scan error: ' . $e->getMessage());
        return response()->json(['success' => false, 'name' => 'Error', 'message' => 'Server error: ' . $e->getMessage()], 500);
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
