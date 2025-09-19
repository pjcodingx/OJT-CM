<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacultyManageStudentsExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;

    public function __construct($request){
        $this->request = $request;
    }

    public function collection()
    {
       $facultyId = Auth::guard('faculty')->id();

    $query = Student::with(['company', 'faculty', 'course'])
                ->where('faculty_id', $facultyId);

    // Filter by company
    if ($this->request->filled('company_id')) {
        $query->where('company_id', $this->request->input('company_id'));
    }

    // Filter by search (name or email)
    if ($this->request->filled('search')) {
        $search = $this->request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    return $query->get();

    }

     public function map($student): array
    {
        return [
            $student->name,
            $student->email,
            $student->course ? $student->course->name : 'N/A',
            $student->company ? $student->company->name : 'N/A',
            $student->faculty ? $student->faculty->name : 'N/A',
            $student->required_hours ?? 0,
        ];
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Course',
            'Company',
            'OJT Adviser',
            'Total Hours'
        ];
    }

      public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 30,
            'C' => 25,
            'D' => 30,
            'E' =>  30,
            'F' => 15,

        ];
    }

      public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:G1')->getFont()->setBold(true);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal('center');

         $sheet->getStyle('A1:G1')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('0b4222');

         $sheet->getStyle('A1:G1')->getFont()->getColor()->setARGB('FFFFFF');

        $sheet->getStyle('A2:G'.$sheet->getHighestRow())
              ->getAlignment()
              ->setHorizontal('center')
              ->setVertical('center');
    }
}
