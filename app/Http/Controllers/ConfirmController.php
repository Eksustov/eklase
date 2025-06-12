<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class ConfirmController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->hasRole('student') || Student::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('status', 'You do not have access to this page.');
        }

        return view('confirm');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user->hasRole('student') || Student::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('status', 'You do not have access to this page.');
        }

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        Student::create([
            'user_id' => $user->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
        ]);

        session(['profile_completed' => true]);

        return redirect()->route('dashboard')->with('status', 'Profile completed!');
    }
}

