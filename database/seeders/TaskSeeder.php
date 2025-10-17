<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
class TaskSeeder extends Seeder
{
    public function run()
    {
        // Get a teacher and a TA from seeded users
        $teacher = User::where('role', 'teacher')->first();
        $ta = User::where('role', 'ta')->first();

        // Create a task assigned to TA
        Task::create([
            'title' => 'Grade Assignment 1',
            'description' => 'Help grade the first homework assignments.',
            'date_time' => now()->addDays(2),
            'urgency' => 'medium',
            'status' => 'accepted',
            'teacher_id' => $teacher?->id,
            'ta_id' => $ta?->id,
        ]);

        // Create an open (unassigned) task
        Task::create([
            'title' => 'Prepare Review Session',
            'description' => 'Prepare materials for student review session.',
            'date_time' => now()->addWeek(),
            'urgency' => 'high',
            'status' => 'pending',
            'teacher_id' => $teacher?->id,
            'ta_id' => null,
        ]);
    }
}
