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
            'title' => 'IS-213 Guidance and Grading',
            'pay' => 120,
            'description' => 'Guide students through IS-213 assignments and grade them.',
            'date_time' => now()->addDays(2),
            'urgency' => 'medium',
            'status' => 'accepted',
            'teacher_id' => $teacher?->id,
            'ta_id' => $ta?->id,
        ]);

        // Create an open (unassigned) task
        Task::create([
            'title' => 'ME-213 Review Session',
            'pay' => 100,
            'description' => 'Review ME-213 assignments and provide feedback.',
            'date_time' => now()->addWeek(),
            'urgency' => 'high',
            'status' => 'pending',
            'teacher_id' => $teacher?->id,
            'ta_id' => null,
        ]);
    }
}
