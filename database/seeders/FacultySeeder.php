<?php

namespace Database\Seeders;

use App\Models\Faculty;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculty = new Faculty();
        $faculty->name = 'Faculty';
        $faculty->email = 'faculty@gmail.com';
        $faculty->password = Hash::make('password'); // Use a secure password


        $faculty->save();
    }
}
