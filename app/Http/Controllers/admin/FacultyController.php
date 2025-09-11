<?php

namespace App\Http\Controllers\admin;

use App\Models\Course;
use App\Models\Company;
use App\Models\Faculty;
use App\Models\Journal;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\StudentRating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FacultyController extends Controller
{
    //
    public function index(Request $request){

        $admin = Auth::guard('admin')->user();
        $faculties = Faculty::with('course')->paginate(8)->withQueryString(); // ✅

         $companies = Company::with('faculty')->get();
        $courses = Course::all();
        $courseCounts = Course::withCount('faculties')->get();

        $query = Faculty::with('course')->withCount('students');

            if ($request->has('search')) {
                $search = $request->input('search');
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
                });
            }


            if ($request->filled('course_id')) {
                $query->where('course_id', $request->input('course_id'));
            }

    $faculties = $query->paginate(8)->withQueryString();

        return view('admin.faculties.index', compact('admin', 'courses', 'courseCounts', 'faculties', 'companies'));

    }

    public function edit($id){
        //edit faculty
        $admin = Auth::guard('admin')->user();

        $faculty = Faculty::findOrFail($id);
        $courses = Course::all();
        $companies = Company::all();

        return view('admin.faculties.edit', compact('admin', 'faculty', 'courses', 'companies'));
    }

    public function update(Request $request, Faculty $faculty){



        $faculty = Faculty::findOrFail($faculty->id);

        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:faculties,email,' . $faculty->id,
        'password' => 'nullable|string|min:6|confirmed',
        'course_id' => 'required|exists:courses,id',
        'company_ids' => 'nullable|array',
        'company_ids.*' => 'exists:companies,id',
    ]);

            $faculty->name = $validated['name'];
            // $faculty->email = $validated['email'];
            $faculty->course_id = $validated['course_id'];

            if (!empty($validated['password'])) {
                $faculty->password = Hash::make($validated['password']);
            }

    $faculty->save();

    $faculty->companies()->sync($validated['company_ids'] ?? []);

        $faculty->companies()->sync($validated['company_ids'] ?? []);

        return redirect()->route('admin.faculties.index')
            ->with('success', 'Adviser updated successfully.');
        }

        public function destroy($id){

            $faculty = Faculty::findOrFail($id);
            $faculty->delete();

            return redirect()->route('admin.faculties.index')
                ->with('success', 'Adviser deleted successfully.');
        }

        public function create(){

            $admin = Auth::guard('admin')->user();
            $courses = Course::all();
            $companies = Company::all();

            return view('admin.faculties.create', compact('admin', 'courses', 'companies'));
        }

        public function store(Request $request){
            //store faculty
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:faculties,email',
                'password' => 'required|min:6|confirmed',
                'course_id' => 'required|exists:courses,id',
                'company_ids' => 'nullable|array',
                'company_ids.*' => 'exists:companies,id',
    ]);


            $faculty = Faculty::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'course_id' => $validated['course_id'],
            ]);

                if (!empty($validated['company_ids'])) {
                    Company::whereIn('id', $validated['company_ids'])
                        ->update(['faculty_id' => $faculty->id]);
                }



            // if (isset($validated['company_ids'])) {
            //     $faculty->companies()->attach($validated['company_ids']);
            // }


            return redirect()->route('admin.faculties.index')
                ->with('success', 'Adviser created successfully.');
        }

        public function viewJournals(){
            $faculty = Auth::guard('faculty')->user();

            $journals = Journal::with([
                'student.course', 'attachments'
            ])->whereHas('student', function($query) use ($faculty){
                $query->where('faculty_id', $faculty->id);
            })->orderBy('journal_date')
                ->paginate(7);

                return view('faculty.journals.index', compact('journals'));
        }

        public function showStudents(Faculty $faculty){
            $admin = Auth::guard('admin')->user();
            //use with to show other realations and display like company name address etc
            $students = $faculty->students()->with(['course', 'company'])->paginate(15);

            return view('admin.faculties.students', compact('admin', 'students', 'faculty'));
        }

        public function showCompanies(Faculty $faculty){
            $admin = Auth::guard('admin')->user();

            $companies = $faculty->companies()->paginate(15);
            $faculty->load('companies');

            return view('admin.faculties.companies', compact('admin', 'companies', 'faculty'));
        }

        public function feedbacks(){
                $faculty = Auth::guard('faculty')->user();


            $students = Student::where('faculty_id', $faculty->id)
                ->with(['ratings.company'])  // load all ratings with company for each student
                ->paginate(8);




            return view('faculty.feedbacks.index', compact('students', 'faculty'));
        }




}
