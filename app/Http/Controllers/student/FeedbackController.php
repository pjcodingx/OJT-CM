<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use App\Models\StudentRating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    //

    public function index(){
             $student = Auth::guard('student')->user();

    $ratings = StudentRating::where('student_id', $student->id)
                ->where('company_id', $student->company->id)
                ->with('company')
                ->first();



                $companyPhoto = null;
                    if ($ratings && $ratings->company) {
                        $companyPhoto = $ratings->company->photo
                            ? asset('uploads/company_photos/' . $ratings->company->photo)
                            : asset('images/default-company-logo.png');
                    }





                    return view('student.feedbacks.index', compact('student', 'ratings', 'companyPhoto'));
                    }
}
