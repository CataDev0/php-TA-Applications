<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, "You are not authorized");
        }

        // If user is a TA, show TA dashboard
        if ($user->isTA()) {
            return view('dashboard.ta');
        }

        // If user is a teacher, show teacher dashboard
        if ($user->isTeacher()) {
            return view('dashboard.teacher');
        }

        // Default fallback
        return redirect()->route('tasks.index');
    }
}
