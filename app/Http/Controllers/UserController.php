<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Controller handling user functionality
class UserController extends Controller
{
    // Profile view
    public function showProfile()
    {
        $user = Auth::user();
        if (!$user) abort(401, "You are not authorized");

        return view('user.profile', ["user" => $user]);
    }

    // Edit profile submit
    public function editProfile(Request $request)
    {
        $user = Auth::user();
        if (!$user) abort(401, "You are not authorized");

        // Validate the form data using specific rules
        $request->validate([
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'username' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Update attributes
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Only update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Profile updated successfully!');
    }
}
