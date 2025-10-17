<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a Teacher
        User::factory()->create([
            'firstname' => 'Bjarne',
            'lastname'  => 'Larsen',
            'username'  => 'bking123',
            'email'     => 'bking123@uia.no',
            "phone"     => "1234567890",
            // Hashing passwords for security reasons
            'password'  => Hash::make('password'),
            'role'      => 'teacher'
        ]);

        // Create a TA
        User::factory()->create([
            'firstname' => 'Lars',
            'lastname'  => 'Kristiansen',
            'username'  => 'lar_ki',
            'email'     => 'larki@uia.no',
            "phone"     => "0987654321",
            'password'  => Hash::make('password'),
            'role'      => 'ta'
        ]);
    }
}
