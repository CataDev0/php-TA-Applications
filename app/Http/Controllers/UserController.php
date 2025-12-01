<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// Controller handling user functionality
class UserController extends Controller
{
    // Profile view
    public function showProfile()
    {
        $user = UserController::authorize();
        $documents = Storage::disk("s3")->allFiles("ta-apps/documents/{$user->id}");

        $files = collect($documents)->map(function ($path) {
            return [
                'name' => basename($path),
                'url' => Storage::disk('s3')->temporaryUrl(
                    $path,
                    now()->addMinutes(30)
                ),
            ];
        });


        return view('user.profile', ["user" => $user, "files" => $files]);
    }

    // Edit profile submit
    public function editProfile(Request $request)
    {
        $user = $user = UserController::authorize();

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
            $password = $request->input('password');
            $password_confirmation = $request->input('password_confirmation');

            if ($password === $password_confirmation) {
                $user->password = Hash::make($password);
            } else {
                return redirect()->back()
                    ->withErrors(['password' => 'Passwords do not match!']);
            }
        }

        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Profile updated successfully!');
    }

    // Edit aboutme profile field
    public function editAboutMe(Request $request)
    {
        $user = UserController::authorize();
        $request->validate([
            'aboutme' => 'nullable|string|max:255',
        ]);
        // Update the about field
        $user->about = $request->aboutme;
        $user->save();

        return redirect()->back()->with('success', '"About me" updated successfully!');
    }

    public function uploadDocument(Request $request) {
        $user = UserController::authorize();
        $request->validate([
            "title" => "required|string|max:50",
            "file" => "required|mimes:pdf,doc,docx,jpg,jpeg,png|max:10000"
        ]);

        $request->file('file')->storeAs("ta-apps/documents/{$user->id}", "$request->title", "s3");

        return redirect()->back()->with('success', 'Document uploaded successfully!');
    }

    private function authorize(): Authenticatable
    {
        $user = Auth::user();
        if (!$user) abort(401, "You are not authorized");
        return $user;
    }
}
