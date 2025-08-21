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

    public function scan(Request $request){
             try {
        // Validate QR input
        $request->validate([
            'qr_code' => 'required|string',
        ]);


        $student = Student::find($request->qr_code);
        if (!$student) {
            return response()->json([
                'success' => false,
                'name' => 'Unknown',
                'message' => 'Student not found.'
            ], 404);
        }

        $company = Auth::guard('company')->user();
        $today = Carbon::today();

         if ($student->company_id !== $company->id) {
            return response()->json([
                'success' => false,
                'name'    => $student->name,
                'message' => 'This student is not assigned to your company.'
            ]);
        }


        $timeInStart  = $company->allowed_time_in_start  ? Carbon::parse($company->allowed_time_in_start)  : Carbon::createFromTime(0, 0, 0);
        $timeInEnd    = $company->allowed_time_in_end    ? Carbon::parse($company->allowed_time_in_end)    : Carbon::createFromTime(23, 59, 59);
        $timeOutStart = $company->allowed_time_out_start ? Carbon::parse($company->allowed_time_out_start) : Carbon::createFromTime(0, 0, 0);
        $timeOutEnd   = $company->allowed_time_out_end   ? Carbon::parse($company->allowed_time_out_end)   : Carbon::createFromTime(23, 59, 59);


        $override = CompanyTimeOverride::where('company_id', $company->id)
            ->whereDate('date', $today)
            ->first();

        if ($override) {
            if ($override->time_in_start && $override->time_in_end) {
                $timeInStart = Carbon::parse($override->time_in_start);
                $timeInEnd   = Carbon::parse($override->time_in_end);
            }
            if ($override->time_out_start && $override->time_out_end) {
                $timeOutStart = Carbon::parse($override->time_out_start);
                $timeOutEnd   = Carbon::parse($override->time_out_end);
            }
        }


        $attendance = Attendance::where('student_id', $student->id)
            ->where('company_id', $company->id)
            ->whereDate('date', $today)
            ->first();

        $now = Carbon::now();


        if (!$attendance) {
            if ($now->between($timeInStart, $timeInEnd)) {
                Attendance::create([
                    'student_id' => $student->id,
                    'company_id' => $company->id, //
                    'time_in'    => $now,
                    'date'       => $today,
                ]);
                return response()->json([
                    'success' => true,
                    'name'    => $student->name,
                    'message' => 'Time In recorded successfully.'
                ]);
            }
            return response()->json([
                'success' => false,
                'name'    => $student->name,
                'message' => 'Time In not allowed at this time.'
            ]);
        }


        if (!$attendance->time_out) {
            if ($now->between($timeOutStart, $timeOutEnd)) {
                $attendance->update([
                    'time_out' => $now
                ]);
                return response()->json([
                    'success' => true,
                    'name'    => $student->name,
                    'message' => 'Time Out recorded successfully.'
                ]);
            }
            return response()->json([
                'success' => false,
                'name'    => $student->name,
                'message' => 'Time Out not allowed at this time.'
            ]);
        }


        return response()->json([
            'success' => false,
            'name'    => $student->name,
            'message' => 'Already completed attendance for today.'
        ]);

    } catch (\Exception $e) {

        Log::error('Scan error: '.$e->getMessage());
        return response()->json([
            'success' => false,
            'name' => 'Error',
            'message' => 'Server error: '.$e->getMessage()
        ], 500);
    }




    }












    public function logs(Request $request){
        $company = Auth::guard('company')->user();

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        //Kuhaon attendances of students
        $attendances = Attendance::whereHas('student', function ($query) use ($company){
            $query->where('company_id', $company->id);
        })->when($startDate, fn($q) => $q->whereDate('date', '>=' , $startDate))
            ->when($endDate, fn($q) => $q->whereDate('date', '<=' , $endDate))
            ->with('student')
            ->orderByDesc('date')
            ->paginate(10);

            return view('company.attendance.logs', compact('company', 'attendances', 'startDate', 'endDate'));
    }
}
