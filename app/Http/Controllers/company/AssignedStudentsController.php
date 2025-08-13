<?php

namespace App\Http\Controllers\company;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssignedStudentsController extends Controller
{
    //

    public function index(Request $request){
      $company = Auth::guard('company')->user();


    $students = Student::with(['faculty', 'attendances'])
        ->where('company_id', $company->id)
        ->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->when($request->sort, function ($query) use ($request) {
            $query->orderBy('required_hours', $request->sort);
        }, function ($query) {
            $query->orderBy('name');
        })
        ->paginate(10)->withQueryString();


    foreach ($students as $student) {
        $totalSeconds = 0;

        foreach ($student->attendances as $log) {
            if ($log->time_in && $log->time_out) {
                $in = Carbon::parse($log->time_in);
                $out = Carbon::parse($log->time_out);
                $totalSeconds += $out->diffInSeconds($in);
            }
        }

        $student->accumulated_hours = round($totalSeconds / 3600, 2);
    }

    return view('company.students.index', compact('company', 'students'));
    }
}
