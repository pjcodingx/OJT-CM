<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    public function dashboard(){
        // This method will return the admin dashboard view
        $admin = Auth::guard('admin')->user();

        //totals
        $studentCount = Student::count();
        $facultyCount = Faculty::count();
        $companyCount = Company::count();
        $courseCount = Course::count();

        //no course yet might add later

        return view('admin.dashboard', compact('admin','studentCount','facultyCount','companyCount', 'courseCount'));
    }




}
