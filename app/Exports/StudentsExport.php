<?php

namespace App\Exports;

use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StudentsExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
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
        $query = Student::with(['course', 'company', 'faculty']);

        if($this->request->filled('search')){
            $search = $this->request->search;

            $query->where(function ($q) use ($search){
                $q->where('name', 'like', '%{$search}%')
                ->orWhere('email', 'like', '%{$search}%');
            });
        }

        if($this->request->filled('course_id')){
            $query->where('course_id', $this->request->course_id);
        }

        if($this->request->filled('status')){
            $query->where('status', $this->request->status);
        }

        return $query->get()->map(function ($student) {
            return [
                'ID' => $student->id,
                'Name' => $student->name,
                'Email' => $student->email,
                'Course' => $student->course->name ?? '--',
                'Company' => $student->company->name ?? '--',
                'OJT Adviser' => $student->faculty->name ?? '--',
                'Total Hours' => $student->required_hours,
            ];
        });


    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email', 'Course', 'Company', 'OJT Adviser', 'Total Hours'];
    }

     public function columnWidths(): array
    {
        return [
            'A' => 25, // Name
            'B' => 30, // Email
            'C' => 25, // Company
            'D' => 30, // Address
            'E' =>  20, // Total Journals
            'F' => 15, // Rating
            'G' => 15, // Total Hours
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
