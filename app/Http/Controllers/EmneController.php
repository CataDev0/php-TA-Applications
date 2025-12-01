<?php

namespace App\Http\Controllers;

use App\Models\TeacherEmne;
use App\Models\TAEmne;
use App\Models\TAPosition;
use App\Models\TAApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmneController extends Controller
{
    // Show teacher's emner management page
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can manage emner.');
        }

        $emner = $user->teacherEmner()->orderBy('emne')->get();

        // Get all unique emner from positions for suggestions
        $allEmner = TAPosition::distinct()->pluck('emne')->sort();

        return view('emner.index', compact('emner', 'allEmner'));
    }

    // Add an emne to teacher's list
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can manage emner.');
        }

        $validated = $request->validate([
            'emne' => 'required|string|max:255',
        ]);

        // Check if already exists
        $exists = TeacherEmne::where('user_id', $user->id)
            ->where('emne', $validated['emne'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'You already have this emne assigned.');
        }

        TeacherEmne::create([
            'user_id' => $user->id,
            'emne' => $validated['emne'],
        ]);

        return redirect()->route('emner.index')->with('success', 'Emne added successfully!');
    }

    // Remove an emne from teacher's list
    public function destroy($id)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can manage emner.');
        }

        $emne = TeacherEmne::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $emne->delete();

        return redirect()->route('emner.index')->with('success', 'Emne removed successfully!');
    }

    // View applications for a specific emne
    public function applications($emne)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can view applications.');
        }

        // Check if teacher has this emne
        if (!$user->hasEmne($emne)) {
            abort(403, 'You do not have access to this emne.');
        }

        // Get all positions for this emne
        $positions = TAPosition::where('emne', $emne)
            ->with(['applications.applicant'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('emner.applications', compact('emne', 'positions'));
    }

    // Accept or reject an application
    public function updateApplicationStatus(Request $request, $applicationId)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can update applications.');
        }

        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected',
        ]);

        $application = TAApplication::with('position')->findOrFail($applicationId);

        // Check if teacher has access to this emne
        if (!$user->hasEmne($application->position->emne)) {
            abort(403, 'You do not have access to this emne.');
        }

        $application->status = $validated['status'];
        $application->save();

        // If accepted, add TA to the emne
        if ($validated['status'] === 'accepted') {
            TAEmne::firstOrCreate([
                'user_id' => $application->user_id,
                'emne' => $application->position->emne,
            ]);
        }

        return redirect()->back()->with('success', 'Application ' . $validated['status'] . ' successfully!');
    }

    // Show form to create a new TA position for an emne
    public function createPosition($emne)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can create positions.');
        }

        // Check if teacher has this emne
        if (!$user->hasEmne($emne)) {
            abort(403, 'You do not have access to this emne.');
        }

        return view('emner.create-position', compact('emne'));
    }

    // Store a new TA position
    public function storePosition(Request $request, $emne)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can create positions.');
        }

        // Check if teacher has this emne
        if (!$user->hasEmne($emne)) {
            abort(403, 'You do not have access to this emne.');
        }

        $validated = $request->validate([
            'description' => 'nullable|string|max:1000',
            'positions_available' => 'required|integer|min:1|max:50',
        ]);

        TAPosition::create([
            'emne' => $emne,
            'description' => $validated['description'] ?? null,
            'positions_available' => $validated['positions_available'],
            'status' => 'open',
            'created_by' => $user->id,
        ]);

        return redirect()->route('emner.applications', $emne)
            ->with('success', 'TA position created successfully!');
    }

    // Toggle position status (open/closed)
    public function togglePositionStatus($positionId)
    {
        $user = Auth::user();

        if (!$user || !$user->isTeacher()) {
            abort(403, 'Only teachers can manage positions.');
        }

        $position = TAPosition::findOrFail($positionId);

        // Check if teacher has access to this emne
        if (!$user->hasEmne($position->emne)) {
            abort(403, 'You do not have access to this emne.');
        }

        $position->status = $position->status === 'open' ? 'closed' : 'open';
        $position->save();

        return redirect()->back()->with('success', 'Position status updated to ' . $position->status . '!');
    }
}

