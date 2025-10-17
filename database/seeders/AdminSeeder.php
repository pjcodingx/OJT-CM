<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Admin 1
        if (!Admin::where('email', 'admin1@gmail.com')->exists()) {
            Admin::create([
                'name' => 'Admin Precious',
                'email' => 'admin1@gmail.com',
                'username' => 'admin1',
                'password' => Hash::make('password'),
            ]);
        }

        // Admin 2
        if (!Admin::where('email', 'admin2@gmail.com')->exists()) {
            Admin::create([
                'name' => 'Admin Two',
                'email' => 'admin2@gmail.com',
                'username' => 'admin2',
                'password' => Hash::make('password'),
            ]);
        }
    }

}
