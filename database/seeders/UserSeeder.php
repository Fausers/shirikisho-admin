<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Define sample user data
        $users = [
            [
                'full_name' => 'Mr Alfred',
                'email' => 'alfred@gmail.com',
                'phone_number' => '123456789',
                'gender' => 'Male',
                'status' => 1,
                'uniform_status' => 1,
                'profile_image' => null,
                'license_number' => 'ABC123',
                'marital_status' => null,
                'dob' => null,
                'residence_address' => null,
                'password' => Hash::make('123'), // Hashed password
                'role' => 1,
                'email_verified_at' => now(),
                'parking_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'archive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'full_name' => 'Jackson Mwatuka',
                'email' => 'jackson@gmail.com',
                'phone_number' => '987654321',
                'gender' => 'Male',
                'status' => 1, 
                'uniform_status' => 1,
                'profile_image' => null,
                'license_number' => 'XYZ456',
                'marital_status' => null,
                'dob' => null,
                'residence_address' => null,
                'password' => Hash::make('123'), // Hashed password
                'role' => 1,
                'email_verified_at' => now(),
                'parking_id' => null,
                'created_by' => null,
                'updated_by' => null,
                'archive' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add more users as needed
        ];

        // Insert sample user data into the database
        User::insert($users);
    }
}