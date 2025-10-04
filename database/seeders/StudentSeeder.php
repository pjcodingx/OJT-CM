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
        $student->password = Hash::make('password'); // Use a secure password


        $student->save();

        if(!Student::where('email', 'student1@gmail.com')->exists()){
            Student::create([
                'name' => 'Kiana Dacunos',
                'email' => 'kiana@gmail.com',
                'password' => Hash::make('password'), // Use a secure password
            ]);
        }

    }
}
