<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PMUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create a test PM user if it doesn't exist
        $pmUser = User::where('nic', '200183503070')->first();

        if (!$pmUser) {
            User::create([
                'name' => 'Test Postmaster',
                'nic' => '200183503070',
                'email' => 'pm@test.com',
                'password' => Hash::make('password123'),
                'user_type' => 'internal',
                'role' => 'pm',
                'is_active' => true,
            ]);

            echo "PM user created successfully!\n";
        } else {
            echo "PM user already exists.\n";
        }

        // Also create a few more test PM users
        $testUsers = [
            [
                'name' => 'John Postmaster',
                'nic' => '199012345678',
                'email' => 'john.pm@test.com',
                'password' => Hash::make('password123'),
                'user_type' => 'internal',
                'role' => 'pm',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Postmaster',
                'nic' => '199123456789',
                'email' => 'jane.pm@test.com',
                'password' => Hash::make('password123'),
                'user_type' => 'internal',
                'role' => 'pm',
                'is_active' => true,
            ]
        ];

        foreach ($testUsers as $userData) {
            $existingUser = User::where('nic', $userData['nic'])->first();
            if (!$existingUser) {
                User::create($userData);
                echo "Created PM user: {$userData['name']}\n";
            }
        }
    }
}
