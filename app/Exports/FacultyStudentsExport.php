<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Student;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class FacultyStudentsExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $facultyId;
    protected $startDate;
    protected $search;

    public function __construct($facultyId, $search){
        $this->facultyId = $facultyId;
        $this->search = $search;
    }

    public function collection()
    {
         $students = Student::with('company', 'journal', 'ratings', 'attendances')
            ->where('faculty_id', $this->facultyId)
            ->when($this->search, function($query) {
                $search = $this->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhereHas('company', function($q2) use ($search) {
                          $q2->where('name', 'like', "%$search%")
                             ->orWhere('address', 'like', "%$search%");
                      });
                });
            })
            ->get();

        // Add totals
        return $students->map(function($student){
            $student->total_journals = $student->journal()->count();
            $student->average_rating = round($student->ratings()->avg('rating') ?? 0, 2);

            $student->total_hours = round($student->attendances()->get()->reduce(function($carry, $attendance){
                if($attendance->time_in && $attendance->time_out){
                    $in = Carbon::parse($attendance->date . ' ' . $attendance->time_in);
                    $out = Carbon::parse($attendance->date . ' ' . $attendance->time_out);
                    $carry += abs($out->timestamp - $in->timestamp) / 3600;
                }
                return $carry;
            }, 0), 1);


                return collect([
                    'Name'           => $student->name ?? '--',
                    'Email'          => $student->email ?? '--',
                    'Company'        => $student->company->name ?? '--',
                    'Address'        => $student->company->address ?? '--',
                    'Total Journals' => $student->total_journals ?? '0',
                    'Rating'         => (float) ($student->average_rating ?? 0),
                    'Appeals Count'  => (int) ($student->appealsCount() ?? 0),
                    'Absences'       => (int) ($student->calculateAbsences() ?? 0),
                    'Total Hours'    => (float) ($student->accumulated_hours ?? 0),
                ]);
        });
    }

    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Company',
            'Address',
            'Total Journals Submitted',
            'Rating',
            'Appeals Submitted',
            'Absences',
            'Total Hours Accumulated'
        ];
    }

      public function columnWidths(): array
    {
        return [
            'A' => 25, // Name
            'B' => 30, // Email
            'C' => 25, // Company
            'D' => 30, // Address
            'E' =>  30, // Total Journals
            'F' => 15, // Rating
            'G' => 20, // Total Hours
            'H' => 15,
            'I' => 25,
        ];
    }

      public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:I1')->getFont()->setBold(true);
        $sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');

         $sheet->getStyle('A1:I1')->getFill()
          ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
          ->getStartColor()->setARGB('0b4222');

         $sheet->getStyle('A1:I1')->getFont()->getColor()->setARGB('FFFFFF');

        $sheet->getStyle('A2:I'.$sheet->getHighestRow())
              ->getAlignment()
              ->setHorizontal('center')
              ->setVertical('center');
    }


    }



