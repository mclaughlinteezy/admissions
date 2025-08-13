<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Application;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        User::create([
            'surname' => 'Admin',
            'first_name' => 'Admissions',
            'email' => 'admin@msu.co.zw',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create sample students with applications
        $student1 = User::create([
            'surname' => 'Mufambi',
            'first_name' => 'McLaughlin',
            'email' => 'mufambi@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'applicant',
        ]);

        
        
    }
}