<?php

namespace App\Http\Controllers\company;

use App\Models\Student;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\StudentRating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentRatingController extends Controller
{
    //

    public function index(){
         $company = Auth::guard('company')->user();

        // Get students assigned to this company with their ratings if any
        $students = Student::where('company_id', $company->id)->where('status', 1)
            ->with(['ratings' => function($q) use ($company) {
                $q->where('company_id', $company->id);
            }])
            ->paginate(5);

        return view('company.students.rating_index', compact('students', 'company'));

    }

      public function edit($studentId)
    {
        $company = Auth::guard('company')->user();

        $student = Student::with('faculty')->findOrFail($studentId);

        // Get existing rating if any
        $rating = StudentRating::where('student_id', $studentId)
            ->where('company_id', $company->id)
            ->first();

        return view('company.students.rating_edit', compact('student', 'rating', 'company'));
    }

       public function update(Request $request, $studentId)
    {
        $company = Auth::guard('company')->user();

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // Update or create rating record
       // Update or create rating record
    $rating = StudentRating::updateOrCreate(
        [
            'student_id' => $studentId,
            'company_id' => $company->id,
        ],
        [
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]
    );


                $student = Student::find($studentId);


                $faculty = $student->facultyAdviser;

                if ($faculty) {
                    Notification::create([
                        'user_id' => $faculty->id,
                        'user_type' => 'faculty',
                        'type' => 'company_feedback',
                        'title' => 'New Company Feedback Submitted',
                        'message' => "Company submitted feedback for student {$student->name}.",

                        'is_read' => false,
                    ]);
                }

                            Notification::create([
                            'user_id' => $student->id,
                            'user_type' => 'student',
                            'type' => 'company_feedback',
                            'title' => 'New Feedback from Company',
                            'message' => "Your company has submitted new feedback.",
                            'is_read' => false,
                        ]);



        return redirect()->route('company.students.rating.index', compact('company'))->with('success', 'Rating and feedback saved.');
    }


}
