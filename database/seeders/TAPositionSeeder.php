<?php

namespace Database\Seeders;

use App\Models\TAPosition;
use App\Models\User;
use Illuminate\Database\Seeder;

class TAPositionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get a teacher user to create positions
        $teacher = User::where('role', 'teacher')->first();

        if (!$teacher) {
            $this->command->warn('No teacher found. Please run UserSeeder first.');
            return;
        }

        $positions = [
            [
                'emne' => 'Webteknologi',
                'description' => 'Looking for a TA to help with web development course. HTML, CSS, JavaScript knowledge required.',
                'positions_available' => 2,
                'status' => 'open',
                'created_by' => $teacher->id,
            ],
            [
                'emne' => 'Algoritmer og Datastrukturer',
                'description' => 'Need TA assistance for algorithms course. Strong programming skills required.',
                'positions_available' => 1,
                'status' => 'open',
                'created_by' => $teacher->id,
            ],
            [
                'emne' => 'Databaser',
                'description' => 'TA position for database course. SQL and database design experience preferred.',
                'positions_available' => 1,
                'status' => 'open',
                'created_by' => $teacher->id,
            ],
            [
                'emne' => 'Programmeringsprosjekt',
                'description' => 'Help students with their programming projects. Multiple languages.',
                'positions_available' => 3,
                'status' => 'open',
                'created_by' => $teacher->id,
            ],
        ];

        foreach ($positions as $position) {
            TAPosition::create($position);
        }

        $this->command->info('TA positions created successfully!');
    }
}
