<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Faculty;
use App\Models\Journal;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\StudentRating;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SummaryReportController extends Controller
{
    //

     public function index()
    {

        $students = Student::select(
                'students.id',
                'students.name',
                'students.email',
                'companies.name as company_name',
                'companies.address'
            )
            ->leftJoin('companies', 'students.company_id', '=', 'companies.id')


            ->withCount('journals')


            ->withSum('attendances as total_hours', 'hours')


            ->addSelect([
                'average_rating' => DB::table('ratings')
                    ->select(DB::raw('AVG(rating)'))
                    ->whereColumn('ratings.student_id', 'students.id')
            ])
            ->get();

        return view('admin.summary.index', compact('students'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();


        $students = Student::where('faculty_id', $request->faculty_id)
            ->with('company') // eager load company info
            ->get();

        $summaryData = [];

        foreach ($students as $student) {

            $totalJournals = Journal::where('student_id', $student->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();

            // Average rating if available
            $rating = StudentRating::where('student_id', $student->id)
                ->avg('score');

            // Total OJT hours
            $totalHours = Attendance::where('student_id', $student->id)
                ->whereBetween('date', [$startDate, $endDate])
                ->sum('hours');

            $summaryData[] = [
                'name'         => $student->name,
                'email'        => $student->email,
                'company'      => $student->company->name ?? 'N/A',
                'address'      => $student->company->address ?? 'N/A',
                'total_journals' => $totalJournals,
                'rating'       => $rating ? number_format($rating, 2) : 'No Rating',
                'total_hours'  => $totalHours,
            ];
        }


        return view('admin.summary.result', compact('summaryData', 'startDate', 'endDate'));
    }

    public function exportStudentSummary(){

         $students = Student::with(['company', 'journals', 'ratings'])
            ->get()
            ->map(function ($student) {
                return [
                    'name' => $student->name,
                    'email' => $student->email,
                    'company' => $student->company->name ?? 'N/A',
                    'company_address' => $student->company->address ?? 'N/A',
                    'total_journals' => $student->journals->count(),
                    'rating' => $student->ratings->avg('rating') ?? 'No rating',
                    'total_hours' => $student->total_hours ?? 0,
                ];
            });


            dd($students);
    }
}
