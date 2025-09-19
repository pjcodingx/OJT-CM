<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $courses = [
            'BSIT',
            'BSA',
            'BSBA',
            'BSED',
            'BSN',
            'BEEd',
            'FPST',
        ];

        foreach ($courses as $course) {
            Course::create(['name' => $course]);
        }
    }
}
