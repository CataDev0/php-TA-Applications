<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

// Homepage
Route::get('/', function () {
    return view('welcome');
});

// Show Login page
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Handle login form submission
Route::post('/login', [LoginController::class, 'login']);

// Handle logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Handle Register form submission
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// All tasks routes, requires authentication
Route::middleware(['auth'])->group(function () {
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
});

// User routes
Route::middleware(['auth'])->group(fn() => [
    Route::get('/profile', [UserController::class, 'showProfile'])->name('user.profile'),
    Route::post('/profile/update', [UserController::class, 'editProfile'])->name('user.editProfile'),
    Route::post('/profile/about', [UserController::class, 'editAboutMe'])->name('user.editAboutMe'),
    Route::post('/profile/upload', [UserController::class, 'uploadDocument'])->name('user.uploadDocument'),
    Route::post('/profile/delete', [UserController::class, 'deleteDocument'])->name('user.deleteDocument'),
]);

// Error page
Route::get("/error", [Controller::class, "error"])->name('error');
