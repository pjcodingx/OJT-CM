<?php

namespace App\Http\Controllers\student;

use App\Models\Student;
use Illuminate\Http\Request;
// use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\Snappy\Facades\SnappyPdf as Pdf;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function previewCertificate($studentId){
        $student = Student::with('course')->findOrFail($studentId);


            $available = $student->hasCompletedOjt();


            return view('student.certificate', [
                'student' => $student,
                'available' => $available,
                'date' => now()->format('F d, Y'),
                'signature_path' => public_path('signatures/faculty_signature.jpg'),
            ]);

    }




   public function preview($studentId)
{
    $student = Student::with('course')->findOrFail($studentId);

    $pdf = Pdf::loadView('student.certificate_pdf', [
            'student' => $student,
            'date' => now()->format('F d, Y'),
            'ojt_coordinator_signature' => public_path('signatures/ojt.png'),
            'president_signature' => public_path('signatures/president.png'),
        ])
        ->setOption('page-size', 'Letter')
        ->setOption('orientation', 'Landscape')
        ->setOption('enable-local-file-access', true)
        ->setOption('margin-top', 0)
         ->setOption('dpi', 150)
        ->setOption('margin-bottom', 0)
        ->setOption('margin-left', 0)
        ->setOption('margin-right', 0);

    return $pdf->download("certificate_{$student->id}.pdf");
}



}
