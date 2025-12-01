<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Controller handling login and logout functionality
class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Attempt to authenticate the user
        // if successful, redirect to the dashboard
        if (Auth::attempt(['username' => $request ->username, 'password' => $request->password])) {
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    // Logout the user, invalidate the session, and redirect to the home page
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect("/");
    }
}
