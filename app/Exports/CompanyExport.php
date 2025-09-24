<?php

namespace App\Exports;

use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompanyExport implements FromCollection, WithColumnWidths, WithStyles, WithHeadings
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
        $query = Company::withCount('students');

        if($this->request->filled('search')){
            $search = $this->request->search;
            $query->where(function ($q) use ($search){
                $q->where('name', 'like', '% {$search} %')
                ->orWhere('email', 'like', '% {search} %')
                ->orWhere('address', 'like', '% {search} %');

            });


            }


            if($this->request->filled('status')){
                $query->where('status', $this->request->status);
            }

            return $query->get()->map(function($company){
                return [
                'Name'            => $company->name,
                'Email'           => $company->email,
                'Address'         => $company->address ?? 'N/A',
                'Status'          => $company->status ? 'Active' : 'Disabled',
                'TraineesAssigned'=> $company->students_count,
                ];
            });

        }

          public function headings(): array
            {
                return ['Name', 'Email', 'Address', 'Status', 'Trainees Assigned'];
            }

        public function columnWidths(): array{

            return[
                'A' => 25,
                'B' => 30,
                'C' => 35,
                'D' => 15,
                'E' => 20,
            ];

        }

        public function styles(Worksheet $sheet){
            $sheet->getStyle('A1:E1')->getFont()->setBold(true);
            $sheet->getStyle('A1:E1')->getAlignment()->setHorizontal('center');

            $sheet->getStyle('A1:E1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('0b4222');

            $sheet->getStyle('A1:E1')->getFont()->getColor()->setARGB('FFFFFF');


            $sheet->getStyle('A2:E'.$sheet->getHighestRow())
                ->getAlignment()
                ->setHorizontal('center')
                ->setVertical('center');
        }


}
