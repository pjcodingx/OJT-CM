<?php

namespace App\Exports;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendanceExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $request;

    public function __construct(Request $request){
        $this->request = $request;
    }


    public function collection()
    {
        $query = Attendance::with(['student.company', 'student.course', 'student.faculty']);

    if($this->request->filled('search')){
        $search = $this->request->input('search');
        $query->whereHas('student', function($q) use ($search){
            $q->where('name', 'like', '%' . $search . '%');
        });
    }

    if($this->request->filled('course_id')){
        $courseId = $this->request->input('course_id');
        $query->whereHas('student.course', function($q) use ($courseId){
            $q->where('id', $courseId);
        });
    }

    if($this->request->filled('faculty_id')){
        $facultyId = $this->request->input('faculty_id');
        $query->whereHas('student.faculty', function($q) use ($facultyId){
            $q->where('id', $facultyId);
        });
    }

     if($this->request->filled('course_id')){
            $query->where('course_id', $this->request->course_id);
        }

    if($this->request->filled('start_date')){
        $query->where('date', '>=', $this->request->input('start_date'));
    }

    if($this->request->filled('end_date')){
        $query->where('date', '<=', $this->request->input('end_date'));
    }

    return $query->orderBy('date', 'desc')->get();



    }

    public function headings(): array{

        return [
            'Name',
            'Email',
            'Course',
            'Faculty Adviser',
            'Company',
            'Address',
            'Date',
            'Time In',
            'Time Out',
            'Accumulated Hours',
        ];
    }

    public function map($attendance): array{

            return [

            $attendance->student->name,
            $attendance->student->email,
            $attendance->student->course->name ?? '-',
            $attendance->student->faculty->name ?? '-',
            $attendance->student->company->name ?? '-',
            $attendance->student->company->address ?? '-',
            \Carbon\Carbon::parse($attendance->date)->format('F d, Y'),
            $attendance->time_in ? \Carbon\Carbon::parse($attendance->time_in)->format('h:i A') : '-',
            $attendance->time_out ? \Carbon\Carbon::parse($attendance->time_out)->format('h:i A') : '-',
            $attendance->student->accumulated_hours . ' hrs',
            ];
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
            'H' => 20,
            'I' => 20,
            'J' => 20
        ];
    }

      public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('A1:J1')->getAlignment()->setHorizontal('center');

            $sheet->getStyle('A1:G1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('0b4222');

            $sheet->getStyle('A1:G1')->getFont()->getColor()->setARGB('FFFFFF');

            $sheet->getStyle('A2:J'.$sheet->getHighestRow())
                ->getAlignment()
                ->setHorizontal('center')
                ->setVertical('center');
    }


}
