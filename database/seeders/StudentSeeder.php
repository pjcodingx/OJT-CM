<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $student = new Student();
        $student->name = 'Student';
        $student->email = 'student@gmail.com';
        $student->username = '20223053';
        $student->password = Hash::make('password'); // Use a secure password


        $student->save();



    }
}
