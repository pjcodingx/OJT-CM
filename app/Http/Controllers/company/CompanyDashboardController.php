<?php

namespace App\Http\Controllers\company;

use Carbon\Carbon;
use App\Models\Company;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\StudentRating;
use App\Models\AttendanceAppeal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyDashboardController extends Controller
{
    //
    public function dashboard(){
         $company = Auth::guard('company')->user();

    $pendingAppeals = AttendanceAppeal::where('status', 'pending')
        ->whereHas('attendance.student', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })->count();

    $studentsCount = Student::where('company_id', $company->id)->count();

    $todayDate = Carbon::today()->toDateString(); // '2025-08-09'

    $timeInCountToday = Attendance::whereHas('student', function ($query) use ($company) {
            $query->where('company_id', $company->id);
        })
        ->where('date', $todayDate)
        ->whereNotNull('time_in')
        ->count();

       $totalRatings = StudentRating::join('students', 'student_ratings.student_id', '=', 'students.id')
                            ->where('students.company_id', $company->id)
                            ->where('student_ratings.company_id', $company->id)
                            ->count();

    return view('company.dashboard', compact('company', 'studentsCount', 'pendingAppeals', 'timeInCountToday', 'totalRatings'));
    }

    public function profile(){
         $company = Auth::guard('company')->user();


        $studentsCount = Student::where('company_id', $company->id)->count();

        return view('company.profile', compact('company', 'studentsCount'));

    }



    public function updatePhoto(Request $request, $id){
        $company = Auth::guard('company')->user();

        $request->validate([
             'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // max 2MB
        ]);

        $company = Company::findOrFail($id);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');


        if ($company->photo && file_exists(public_path('uploads/company_photos/' . $company->photo))) {
            unlink(public_path('uploads/company_photos/' . $company->photo));
        }


            $filename = time() . '_' . $photo->getClientOriginalName();
        $photo->move(public_path('uploads/company_photos'), $filename);

        $company->photo = $filename;
        $company->save();

        return back()->with('success', 'Profile photo updated successfully!');
        }

        return back()->withErrors(['photo' => 'Please select a valid image file.']);
    }

}
