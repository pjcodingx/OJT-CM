<?php

namespace App\Http\Controllers\faculty;

use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FacultyStudentsExport;

class FacultyReportController extends Controller
{
    //

    public function index(Request $request){
         $faculty = Auth::guard('faculty')->user();


   $students = Student::with('company', 'journal', 'ratings', 'attendances')
    ->where('faculty_id', $faculty->id)
    ->when($request->search, function ($query) use ($request) {
        $search = $request->search;

        $query->where(function($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhereHas('company', function($q2) use ($search) {
                  $q2->where('name', 'like', '%' . $search . '%')
                     ->orWhere('address', 'like', '%' . $search . '%');
              });
        });
    })
    ->paginate(10);


    // Calculate filtered values per student
    foreach ($students as $student) {


        $student->total_journals = $student->journal()
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            })
            ->count();


        $student->average_rating = $student->ratings()
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('created_at', [
                    $request->start_date . ' 00:00:00',
                    $request->end_date . ' 23:59:59'
                ]);
            })
            ->avg('rating');


        $student->total_hours = $student->attendances()
            ->when($request->start_date && $request->end_date, function ($q) use ($request) {
                $q->whereBetween('date', [$request->start_date, $request->end_date]);
            })
            ->get()
            ->reduce(function ($carry, $attendance) {
                if ($attendance->time_in && $attendance->time_out) {
                    $in = \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->time_in);
                    $out = \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->time_out);
                    $carry += abs($out->timestamp - $in->timestamp) / 3600;
                }
                return $carry;
            }, 0);
    }

    return view('faculty.reports.index', compact('students', 'faculty'));
    }

    public function exportExcel(Request $request)
    {
        $faculty = Auth::guard('faculty')->user();

        return Excel::download(new FacultyStudentsExport($faculty->id, $request->search), 'students_summary.xlsx');
    }

    public function exportPdf(Request $request)
{
    $faculty = Auth::guard('faculty')->user();


    $students = Student::with('company', 'journal', 'ratings', 'attendances')
        ->where('faculty_id', $faculty->id)
        ->when($request->search, function ($query) use ($request) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhereHas('company', function($q2) use ($search) {
                      $q2->where('name', 'like', '%' . $search . '%')
                         ->orWhere('address', 'like', '%' . $search . '%');
                  });
            });
        })
        ->get();


    foreach ($students as $student) {
        $student->total_journals = $student->journal()->count();
        $student->average_rating = $student->ratings()->avg('rating');
        $student->total_hours = $student->attendances()->get()->reduce(function ($carry, $attendance) {
            if ($attendance->time_in && $attendance->time_out) {
                $in = \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->time_in);
                $out = \Carbon\Carbon::parse($attendance->date . ' ' . $attendance->time_out);
                $carry += abs($out->timestamp - $in->timestamp) / 3600;
            }
            return $carry;
        }, 0);
    }

    $pdf = Pdf::loadView('faculty.reports.students-pdf', compact('students'));
    return $pdf->download('students_summary.pdf');
}




    }


