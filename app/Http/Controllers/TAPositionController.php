<?php

namespace App\Http\Controllers;

use App\Models\TAPosition;
use App\Models\TAApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TAPositionController extends Controller
{
    // Show all open TA positions
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->isTA()) {
            abort(403, 'Only TAs can view positions.');
        }

        // Get ALL open positions - TAs should see all positions to apply
        // They don't need to be assigned to an emne to see and apply for positions
        $positions = TAPosition::where('status', 'open')
            ->with(['applications' => function($query) use ($user) {
                $query->where('user_id', $user->id);
            }])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('ta-positions.index', compact('positions'));
    }

    // Apply for a TA position
    public function apply(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user || !$user->isTA()) {
            abort(403, 'Only TAs can apply for positions.');
        }

        $position = TAPosition::findOrFail($id);

        if (!$position->isOpen()) {
            return redirect()->back()->with('error', 'This position is no longer open.');
        }

        // Check if already applied
        $existingApplication = TAApplication::where('ta_position_id', $id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingApplication) {
            return redirect()->back()->with('error', 'You have already applied for this position.');
        }

        $validated = $request->validate([
            'message' => 'nullable|string|max:1000',
        ]);

        TAApplication::create([
            'ta_position_id' => $id,
            'user_id' => $user->id,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('ta-positions.index')->with('success', 'Application submitted successfully!');
    }
}
