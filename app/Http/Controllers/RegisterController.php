<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Controller handling registration functionality
class RegisterController extends Controller
{
    // Simply returns the registration view
    public function showRegistrationForm()
    {
        return view('register');
    }

    // Handles the registration form submission
    public function register(Request $request)
    {
        // Validate the form data using specific rules
        $request ->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:teacher,ta',
        ]);

        // Create a new user instance and save it to the database
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        Auth::login($user);

        return redirect()->route('tasks.index');
    }
}
