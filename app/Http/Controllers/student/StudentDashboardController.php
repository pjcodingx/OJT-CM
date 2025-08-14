<?php

namespace App\Http\Controllers\student;

use App\Models\Journal;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AttendanceAppeal;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class StudentDashboardController extends Controller
{
    public function dashboard(){
        $student = Auth::guard('student')->user();

         $journalCount = Journal::where('student_id', $student->id)->count();
        $studentsOjt = Student::with('attendances')->findOrFail(Auth::guard('student')->id());

       $appealsCount = AttendanceAppeal::where('student_id', $student->id)->count();



        return view('student.dashboard', compact('student', 'journalCount', 'studentsOjt', 'appealsCount'));
    }

    public function profile(){
        $student = Auth::guard('student')->user();

        return view('student.profile', compact('student', ));
    }

    public function updatePhoto(Request $request, $id){

        $request->validate([
        'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

        $student = Student::findOrFail($id); // ensures you get a valid model


        if ($student->photo && file_exists(public_path('uploads/student_photos/' . $student->photo))) {
            unlink(public_path('uploads/student_photos/' . $student->photo));
        }


        $file = $request->file('photo');
        $filename = time() . '.' . $file->getClientOriginalName();
        $file->move(public_path('uploads/student_photos'), $filename);

        $student->photo = $filename;
        $student->save();

        return back()->with('success', 'Photo updated successfully.');
    }

    public function updatePassword(Request $request){
        $student = Auth::guard('student')->user();

        $validated = $request->validate([
            'password' => 'required|min:8|confirmed',

        ]);


    Student::where('id', $student->id)
        ->update(['password' => Hash::make($validated['password'])]);

        return redirect()->back()->with('success', 'Password Successfuly Changed!');
    }

    public function change(){
        $student = Auth::guard('student')->user();

        return view('student.change-password', compact('student'));
    }

    public function index()
    {
        //

    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show(string $id)
    {
        //
    }


    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }
}
