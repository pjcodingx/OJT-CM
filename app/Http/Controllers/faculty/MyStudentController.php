<?php

namespace App\Http\Controllers\faculty;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Student;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Exports\StudentsExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Exports\FacultyManageStudentsExport;

class MyStudentController extends Controller
{
    //

    public function index(Request $request){
        $faculty = Auth::guard('faculty')->user();


    $students = Student::with(['course', 'company', 'attendances'])
        ->where('faculty_id', $faculty->id)
        ->where('status', 1)
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

    public function allStudents(Request $request){
        $faculty = Auth::guard('faculty')->user();
        $courseCounts = Course::withCount('students')->get();
        $courses = Course::all();
        $companies = Company::withCount('students')->where('faculty_id', $faculty->id)->get();
        //* So here I added where clause to specify the relation to be filtered meaning
        //* only shows the partnered company of the faculty

        $students = Student::with('company', 'faculty', 'course')
            ->where('faculty_id', $faculty->id)
            ->where('status', 1)
            ->when($request->company_id, function ($query) use ($request){
                $query->where('company_id', $request->company_id);

            })->when($request->search, function ($query) use ($request){
            $query->where(function($subQuery) use ($request){
                $subQuery->where('name', 'like', '%' . $request->search . '%'
                )->orWhere('email', 'like', '%' . $request->search . '%');
            });
        })->paginate(5)->withQueryString();

        return view('faculty.manage-students.index', compact('students', 'faculty', 'courseCounts', 'courses', 'companies'));
    }

    public function create(){
        $faculty = Auth::guard('faculty')->user();
        $companies = Company::where('faculty_id', $faculty->id)->get();
        $faculties = Faculty::all();
        $courses = Course::all();
        return view('faculty.manage-students.create', compact('faculty', 'courses', 'faculties', 'companies'));
    }

    public function store(Request $request){
        $faculty = Auth::guard('faculty')->user();

        $validated =  $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',

            'course_id' => 'required|exists:courses,id',
            'company_id' => 'nullable|exists:companies,id',
            'faculty_id' => 'nullable|exists:faculties,id',
            'required_hours' => 'required|numeric|min:1',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['faculty_id'] = $faculty->id;

        $student = Student::create($validated);
        $admin = Admin::first();

        if($admin){
            Notification::create([
                'user_id' => $admin->id,
                'user_type' => 'admin',
                'title' => 'New Trainee Registered',
                'message' => 'Adviser ' . $faculty->name . ' added a new trainee: ' . $student->name,
                'type' => 'info',
                'is_read' => 0
            ]);
        }

        return redirect()->route('faculty.manage-students.create')->with('success', 'Student created successfully.');
    }

    public function generateQR($id){

        $student = Student::findOrFail($id);
        $courseName = $student->course ? $student->course->name : 'No Course';

        $qrText = (string) $student->id;

        $filename = 'qr_codes/student_qr_' . $student->id . '.png';

        $result = Builder::create()
        ->data($qrText)
        ->size(300)
        ->margin(10)
        ->build();

        Storage::disk('public')->put($filename, $result->getString());

        $student->qr_code_path = $filename;
        $student->save();

        return back()->with('success', 'QR code generated and saved successfully.');

    }


    public function edit($id){

        $faculty = Auth::guard('faculty')->user();

        $student = Student::findOrFail($id);
        $courses =  Course::all();
        $faculties = Faculty::all();
        $companies = Company::where('faculty_id', $faculty->id)->get();

        return view('faculty.manage-students.edit', compact('student', 'courses', 'faculties', 'companies', 'faculty'));
    }

    public function update(Request $request, $id){
        $faculty = Auth::guard('faculty')->user();
          $student = Student::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
            'course_id' => 'required|exists:courses,id',
            'company_id' => 'nullable|exists:companies,id',

            'required_hours' => 'required|numeric|min:1',
            'regenerate_qr' => 'nullable|boolean',
        ]);


            $student->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'course_id' => $validated['course_id'],
            'company_id' => $validated['company_id'],

            'required_hours' => $validated['required_hours'],
    ]);
        //para di ka ma force ug update ug password!
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
                $student->faculty_id = $faculty->id;
                $student->save();
        }

        return redirect()->route('faculty.manage-students.index')->with('success', 'Student updated successfully.');

    }

    //!Export files

     public function exportExcel(Request $request){
        return Excel::download(new FacultyManageStudentsExport($request), 'faculty_students.xlsx');
    }

     public function exportPDF(Request $request)
{

    $students = (new FacultyManageStudentsExport($request))->collection();


    $pdf = Pdf::loadView('faculty.manage-students.students_pdf', [
        'students' => $students,
        'date' => Carbon::now()->format('F d, Y'),
    ]);

    return $pdf->download('faculty_students_summary.pdf');
}




}
