<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StudentController extends Controller
{

    public function index(Request $request){
        // Get method to list all students
        $admin = Auth::guard('admin')->user();
        $courseCounts = Course::withCount('students')->get();

        $courses = Course::all();

        //accepts course_id from filter

        $students = Student::with('company', 'faculty', 'course')->when($request->course_id,
        function($query) use ($request){
            $query->where('course_id', $request->course_id);

        })->when($request->search, function($query) use ($request){
            $query->where(function($subQuery) use ($request){
                $subQuery->where('name', 'like', '%' . $request->search . '%'
                )->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })->paginate(5)->withQueryString();


        return view('admin.students.index', compact('admin','students', 'courseCounts', 'courses'));
    }

    public function create(){ //create accounts
        $admin = Auth::guard('admin')->user();

        $companies = Company::all();
        $faculties = Faculty::all();
        $courses = Course::all();
        return view('admin.students.create', compact('admin','companies', 'faculties', 'courses'));
    }

    public function store(Request $request){ //submit form and store in database


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',

            'course_id' => 'required|exists:courses,id',
            'company_id' => 'nullable|exists:companies,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'required_hours' => 'required|numeric|min:1',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        Student::create($validated);
        return redirect()->route('admin.students.create')->with('success', 'Student created successfully.');



    }

    public function destroy($id){ //delete student account
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->back()->with('success', 'Student deleted successfully.');
    }

    public function generateQR($id){

        $student = Student::findOrFail($id);
        $courseName = $student->course ? $student->course->name : 'N/A';

        $qrText = $student->name . ' | ' . $courseName;

        $filename = 'qr_codes/student_qr_' . $student->id . '.png';

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($qrText)
            ->size(300)
            ->margin(10)
            ->build();

    // Save to storage/app/public/qr_codes/
        Storage::disk('public')->put($filename, $result->getString());

        $student->qr_code_path = $filename;
        $student->save();

        return back()->with('success', 'QR Code generated successfully.');
    }

    public function edit($id){

        $admin = Auth::guard('admin')->user();

        $student = Student::findOrFail($id);
        $courses =  Course::all();
        $faculties = Faculty::all();
        $companies = Company::all();

        return view('admin.students.edit', compact('student', 'courses', 'faculties', 'companies', 'admin'));
    }

    public function update(Request $request , $id){
        $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'course_id' => 'required|exists:courses,id',
            'company_id' => 'nullable|exists:companies,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'required_hours' => 'required|numeric|min:1',
            'regenerate_qr' => 'nullable|boolean',
        ]);


          $student->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'course_id' => $validated['course_id'],
            'company_id' => $validated['company_id'],
            'faculty_id' => $validated['faculty_id'],
            'required_hours' => $validated['required_hours'],
    ]);

        if (!empty($validated['password'])) {
            $student->password = Hash::make($validated['password']);
            $student->save();
        }

        if($request->input('regenerate_qr') == '1'){

            if ($student->qr_code_path && Storage::disk('public')->exists($student->qr_code_path)) {
                Storage::disk('public')->delete($student->qr_code_path);
                }
            $qrdata = $student->name . ' | ' . optional($student->course)->name;


            $result = Builder::create()
            ->data($qrdata)
            ->writer(new PngWriter())
            ->size(300)
            ->margin(10)
            ->build();

              $filename = 'student_qr' . $student->id . '.png'; //file name sa photo stored sa storage
                Storage::disk('public')->put($filename, $result->getString());

                $student->qr_code_path = $filename;
                $student->save();
        }

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');




    }
}
