<?php

namespace App\Http\Controllers\company;

use Illuminate\Http\Request;
use App\Models\AttendanceAppeal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyAttendanceAppealController extends Controller
{
    public function index(){
        $company = Auth::guard('company')->user();



        //! ato kuhaon ang appeals from the students i display
        $appeals = AttendanceAppeal::with(['attendance.student'])
                    ->where('status', 'pending')
                    ->whereHas('attendance.student', function($query) use ($company){
                        $query->where('company_id' , $company->id);
                    })->orderBy('created_at', 'desc')->get();

                    return view('company.attendance-appeals.index', compact('appeals', 'company'));
        }
        public function approve(Request $request, $id){
                $request->validate([
                    'credited_hours' => 'nullable|numeric|min:0'
                ]);

                $appeal = AttendanceAppeal::findOrFail($id);

                //making sure nga ang appeal belongs to student ani nga comnpany
                if($appeal->attendance->student->company_id !== Auth::guard('company')->id()){
                    abort(403);
                }

                $appeal->status = 'approved';
                $appeal->credited_hours = $request->credited_hours ?? 0;
                $appeal->save();

                 // Notify the student
                $student = $appeal->attendance->student;

                \App\Models\Notification::createLimited([
                    'user_id' => $student->id,
                    'user_type' => 'student',
                    'type' => 'approve',
                    'title' => 'Attendance Appeal Approved',
                    'message' => "Your attendance appeal dated {$appeal->created_at->toFormattedDateString()} has been approved.",
                    'is_read' => false,
                ]);

                return back()->with('success', 'Appeal Approved Successfully.');
        }

        public function reject(Request $request, $id){

            $request->validate([
                'reject_reason' => 'required|string|max:255'
            ]);

            $appeal = AttendanceAppeal::findOrFail($id);

            if($appeal->attendance->student->company_id !== Auth::guard('company')->id()){
                    abort(403);

            }

              if ($appeal->status !== 'pending') {
        return back()->with('error', 'This appeal has already been processed.');
    }

            $appeal->status = 'rejected';
            $appeal->reject_reason = $request->reject_reason;
            $appeal->save();

             // Notify the student
            $student = $appeal->attendance->student;

            \App\Models\Notification::createLimited([
                'user_id' => $student->id,
                'user_type' => 'student',
                'type' => 'reject',
                'title' => 'Attendance Appeal Rejected',
                'message' => "Your attendance appeal dated {$appeal->created_at->toFormattedDateString()} has been rejected.",
                'is_read' => false,
            ]);

            return back()->with('success', 'Appeal rejected Successfully');
        }







    public function update(Request $request, $id){

        $appeal = AttendanceAppeal::findOrFail($id);

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'reject_reason' => 'nullable|string|max:2000',
            'time_credited' => 'nullable|numeric|min:0|max:10',
        ]);

        $appeal->status = $request->status; //mangaju sa appeal status

        if($request->status == 'approved'){
            //if approved hatagan ug time

            $request->validate([
                'time_credited' => 'required|numeric|min:0|max:10',
            ]);

            $appeal->time_credited = $request->time_credited;
            $appeal->reject_reason = null;
        }

        $appeal->save();

        return redirect()->back()->with('success', 'Appeal updated Successfuly!');
    }
}
