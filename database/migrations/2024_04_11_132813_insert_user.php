<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Users data to be inserted
        $users = [
            [
                'full_name' => 'Alfred',
                'email' => 'alfred@gmail.com',
                'phone_number' => '255712902992',
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
                'phone_number' => '255786147878',
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
        ];

        // Inserting users into the users table
        DB::table('users')->insert($users);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // You can remove the inserted users here, but it's generally not recommended
    }
};
