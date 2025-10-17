<?php

namespace App\Http\Controllers\company;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\OvertimeRequest;
use App\Models\AttendanceAppeal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CompanyOvertimeRequestController extends Controller
{
      public function index()
    {
        $company = Auth::guard('company')->user();

        // Get all overtime requests submitted by the company's students
        $requests = OvertimeRequest::with('student')
            ->where('company_id', $company->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('company.overtime.index', compact('requests'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'approved_hours' => 'required|numeric|min:0.5|max:8',
            'scan_start'     => 'required|date_format:H:i',
            'scan_end'       => 'required|date_format:H:i|after:scan_start',
            'status'         => 'required|in:approved,rejected',
            'remarks'        => 'nullable|string|max:255',
        ]);

        $ot = OvertimeRequest::findOrFail($id);

        $ot->update([
            'approved_hours' => $request->approved_hours,
            'scan_start'     => $request->scan_start,
            'scan_end'       => $request->scan_end,
            'status'         => $request->status,
            'remarks'        => $request->remarks,
        ]);

        return back()->with('success', 'Overtime request updated successfully.');
    }

     public function approve(Request $request, $id)
    {
        $request->validate([
            'approved_hours' => 'required|numeric|min:0.5|max:8',
            'scan_start'     => 'required|date_format:H:i',
            'scan_end'       => 'required|date_format:H:i|after:scan_start',
            'remarks'        => 'nullable|string|max:255',
        ]);

        $ot = OvertimeRequest::findOrFail($id);
        $ot->update([
            'approved_hours' => $request->approved_hours,
            'scan_start'     => $request->scan_start,
            'scan_end'       => $request->scan_end,
            'remarks'        => $request->remarks,
            'status'         => 'approved',
        ]);

        Notification::createLimited([
                    'user_id' => $ot->student_id,
                    'user_type' => 'student',
                    'type' => 'overtime',
                    'title' => 'Overtime request Approved',
                    'message' => "Your overtime request for {$ot->date} has been approved for {$ot->approved_hours} hours.",
                    'is_read' => false,

            ]);

        return back()->with('success', 'Overtime request approved.');
    }

      public function reject(Request $request, $id)
    {
        $request->validate([
            'remarks' => 'required|string|max:255',
        ]);

        $ot = OvertimeRequest::findOrFail($id);
        $ot->update([
            'status'  => 'rejected',
            'remarks' => $request->remarks,
        ]);

        Notification::createLimited([
                    'user_id' => $ot->student_id,
                    'user_type' => 'student',
                    'type' => 'overtime-rejected',
                    'title' => 'Overtime request Rejected',
                    'message' => "Your overtime request for {$ot->date} has been rejected",

                    'is_read' => false,

            ]);

        return back()->with('error', 'Overtime request rejected.');
    }


    //!ALL
    public function approveAll(Request $request)
{
    $company = Auth::guard('company')->user();
    $pendingRequests = OvertimeRequest::where('company_id', $company->id)
        ->where('status', 'pending')
        ->get();

    foreach ($pendingRequests as $req) {
        $req->update([
            'approved_hours' => $request->approved_hours,
            'scan_start' => $request->scan_start,
            'scan_end' => $request->scan_end,
            'remarks' => $request->remarks,
            'status' => 'approved',
        ]);
    }

    return redirect()->back()->with('success', 'All pending overtime requests have been approved.');
}

public function rejectAll(Request $request)
{
    $company = Auth::guard('company')->user();
    $pendingRequests = OvertimeRequest::where('company_id', $company->id)
        ->where('status', 'pending')
        ->get();

    foreach ($pendingRequests as $req) {
        $req->update([
            'approved_hours' => 0,
            'scan_start' => '00:00',
            'scan_end' => '00:00',
            'remarks' => $request->remarks,
            'status' => 'rejected',
        ]);
    }

    return redirect()->back()->with('success', 'All pending overtime requests have been rejected.');
}






}
