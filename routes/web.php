<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});

// Show Login page
// This can be moved to a controller
Route::get('/login', function () {
    return view('login');
});

// Show all tasks for the logged-in user (dashboard)
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');

// Show the form to create a new task (Teacher only)
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');

// Store a new task
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');

// TA accepts a task
Route::post('/tasks/{id}/accept', [TaskController::class, 'accept'])->name('tasks.accept');

// Mark a task as completed
Route::post('/tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

Route::get("/error", [TaskController::class, "error"])->defaults("error", "Generic error");