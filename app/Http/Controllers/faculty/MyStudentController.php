<?php

namespace App\Http\Controllers\faculty;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyStudentController extends Controller
{
    //

    public function index(Request $request){
        $faculty = Auth::guard('faculty')->user();


    $students = Student::with(['course', 'company', 'attendances'])
        ->where('faculty_id', $faculty->id)
        ->when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->when($request->sort, function ($query) use ($request) {
            $query->orderBy('required_hours', $request->sort);
        }, function ($query) {
            $query->orderBy('name');
        })
        ->paginate(10);


    foreach ($students as $student) {
    $totalSeconds = 0;


}


    return view('faculty.students.index', compact('students', 'faculty'));
    }
}
