<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            FacultySeeder::class,
            StudentSeeder::class,
            CompanySeeder::class,
            CourseSeeder::class,
            // Add other seeders here as needed
        ]);

    }
}
