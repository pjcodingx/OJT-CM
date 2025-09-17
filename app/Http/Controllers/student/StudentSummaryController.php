<?php

namespace App\Http\Controllers\student;

use Carbon\Carbon;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class StudentSummaryController extends Controller
{

      protected function buildPdfData(int $id): array
    {
        $student = Student::with([
            'company', 'faculty', 'course', 'journal', 'ratings', 'attendances', 'attendanceAppeals'
        ])->findOrFail($id);

        // counts
        $totalAttendance   = $student->attendances()->count();
        // missed where either time_in or time_out is null
        $missedAttendance  = $student->attendances()->where(function ($q) {
            $q->whereNull('time_in')->orWhereNull('time_out');
        })->count();

        $numberOfAppeals   = $student->attendanceAppeals()->count();
        // your model relationship used earlier is `journal()` so keep that
        $submittedJournals = $student->journal()->count();

        // rating / feedback
        $averageRating     = round($student->ratings()->avg('rating') ?? 0, 2);
        // collect non-empty feedbacks
        $feedbacksList     = $student->ratings->pluck('feedback')->filter()->values()->all();
        $feedbacksText     = count($feedbacksList) ? implode("\n\n", $feedbacksList) : null;

        // accumulated hours: you said you have getAccumulatedHoursAttribute()
        // that translates to $student->accumulated_hours
        $accumulatedHours = method_exists($student, 'getAccumulatedHoursAttribute')
            ? $student->accumulated_hours
            : round($student->attendances->reduce(function ($carry, $att) {
                if ($att->time_in && $att->time_out) {
                    $in  = Carbon::parse($att->date . ' ' . $att->time_in);
                    $out = Carbon::parse($att->date . ' ' . $att->time_out);
                    $carry += $out->diffInSeconds($in) / 3600;
                }
                return $carry;
            }, 0), 1);

        // Profile photo base64 (DomPDF reliable)
        $photoFile = public_path('uploads/student_photos/' . ($student->photo ?? 'default.png'));
        $profileImageData = null;
        if (file_exists($photoFile)) {
            $type = pathinfo($photoFile, PATHINFO_EXTENSION) ?: 'png';
            $data = file_get_contents($photoFile);
            $profileImageData = 'data:image/' . $type . ';base64,' . base64_encode($data);
        }

        // school info (custom)
        $schoolName  = 'The College Of Maasin';
        $schoolQuote = config('school.quote', 'Nisi Dominus Frustra');
        $schoolPlace = config('school.place', 'Maasin City');

        $date = Carbon::now()->format('F d, Y');

        return [
            'student'          => $student,
            'totalAttendance'  => $totalAttendance,
            'missedAttendance' => $missedAttendance,
            'numberOfAppeals'  => $numberOfAppeals,
            'submittedJournals'=> $submittedJournals,
            'averageRating'    => $averageRating,
            'feedbacksList'    => $feedbacksList,
            'feedbacksText'    => $feedbacksText,
            'accumulatedHours' => $accumulatedHours,
            'profileImageData' => $profileImageData,
            'schoolName'       => $schoolName,
            'schoolQuote'      => $schoolQuote,
            'schoolPlace'      => $schoolPlace,
            'date'             => $date,
        ];
    }


    public function download($id)
    {
        $data = $this->buildPdfData($id);
        $pdf = Pdf::loadView('pdf.student_summary', $data)->setPaper('a4', 'portrait');
        return $pdf->download("student_summary_{$data['student']->id}.pdf");
    }


    public function preview($id)
    {
         $student = Auth::guard('student')->user();
        $data = $this->buildPdfData($student->id); // use logged-in student id

        $pdf = Pdf::loadView('pdf.student_summary', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('defaultFont', 'DejaVuSans')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream("student_summary_{$student->id}.pdf");
    }

}
