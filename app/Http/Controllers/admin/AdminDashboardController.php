<?php

namespace App\Http\Controllers\admin;

use Carbon\Carbon;
use App\Models\Course;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Journal;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function dashboard(){

        $admin = Auth::guard('admin')->user();

        //counting only the active students
        $studentCount = Student::where('status', 1)->count();
        $facultyCount = Faculty::where('status', 1)->count();
        $companyCount = Company::where('status', 1)->count();
        $courseCount = Course::count();

        //! DONE ADDING COURSES

        return view('admin.dashboard', compact('admin','studentCount','facultyCount','companyCount', 'courseCount'));
    }

    public function index(Request $request){
        $admin = Auth::guard('admin')->user();
        //filter ni for faculty search and dates
        $facultyId = $request->get('faculty_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');


        $journals = Journal::with(['student.faculty'])
    ->whereHas('student', function ($q) {
        $q->where('status', 1); // ✅ only active students
    })
    ->when($facultyId, function ($query) use ($facultyId) {
        $query->whereHas('student', function ($q) use ($facultyId) {
            $q->where('faculty_id', $facultyId);
        });
    })
    ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
        $query->whereBetween('created_at', [
            Carbon::parse($startDate)->startOfDay(),
            Carbon::parse($endDate)->endOfDay(),
        ]);
    })
    ->latest()
    ->paginate(10);


        return view('admin.index', compact('facultyId', 'journals', 'startDate', 'endDate', 'admin'));
    }




}
