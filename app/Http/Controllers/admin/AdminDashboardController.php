<?php

namespace App\Http\Controllers\admin;

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

        //totals
        $studentCount = Student::count();
        $facultyCount = Faculty::count();
        $companyCount = Company::count();
        $courseCount = Course::count();

        //! DONE ADDING COURSES

        return view('admin.dashboard', compact('admin','studentCount','facultyCount','companyCount', 'courseCount'));
    }

    public function index(Request $request){

        $facultyId = $request->get('faculty_id');
        $startDate = $request->get('start_date');
        $endDate = $request->get('end_date');


        $journals = Journal::with(['student.faculty'])->when($facultyId, function ($query) use ($facultyId){
            $query->whereHas('student', function ($q) use ($facultyId){
                $q->where('faculty_id', $facultyId);
            });
        })->when($startDate && $endDate, function ($query) use ($startDate, $endDate){
            $query->whereBetween('created_at', [
                $startDate . '00:00:00',
                $endDate . '23:59:59'
            ]);
        })
        ->latest()->paginate(10);

        return view('admin.index', compact('facultyId', 'journals', 'startDate', 'endDate'));
    }




}
