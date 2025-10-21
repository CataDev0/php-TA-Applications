<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use function Laravel\Prompts\error;

class TaskController extends Controller
{
    // Show all tasks relevant to the logged-in user
    public function index()
    {
        $user = Auth::user();
        if (!$user) abort(401, "You are not authorized");

        if ($user->isTeacher()) {
            // Teachers see tasks they created
            $tasks = Task::where('teacher_id', $user->id)->get();
        }
        else {
            // TAs see open tasks and tasks they accepted
            $tasks = Task::where(function ($query) use ($user) {
                $query->whereNull('ta_id')
                      ->orWhere('ta_id', $user->id);
            })->get();
        }

        return view('tasks.index', compact('tasks'));
    }

    // Show form to create a new task (Teacher only)
    public function create()
    {
        $user = Auth::user();
        if (!$user->isTeacher()) {
            abort(403, 'Only teachers can create tasks.');
        }

        return view('tasks.create');
    }

    // Store a new task in the database
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user->isTeacher()) {
            abort(403, 'Only teachers can create tasks.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'nullable|date',
            'urgency' => 'nullable|string|max:50',
        ]);

        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'date_time' => $validated['date_time'] ?? null,
            'urgency' => $validated['urgency'] ?? null,
            'status' => 'pending',
            'teacher_id' => $user->id,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    // TA accepts a task
    public function accept($id)
    {
        $user = Auth::user();
        if (!$user->isTA()) {
            abort(403, 'Only TAs can accept tasks.');
        }

        $task = Task::findOrFail($id);
        if ($task->ta_id) {
            return redirect()->back()->with('error', 'Task already accepted.');
        }

        $task->ta_id = $user->id;
        $task->status = 'accepted';
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task accepted!');
    }

    // Mark a task as completed (Teacher or TA)
    public function complete($id)
    {
        $task = Task::findOrFail($id);

        // Only the teacher or assigned TA can mark as complete
        $user = Auth::user();
        if ($user->id !== $task->teacher_id && $user->id !== $task->ta_id) {
            abort(403, 'You cannot complete this task.');
        }

        $task->status = 'completed';
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task marked as completed!');
    }

    public function error($error) {
        return view("/error")->with("error", "Generic error");
    }
}
