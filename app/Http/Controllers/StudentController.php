<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
        ]);

        $user = Auth::user();

        if (Student::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('status', 'Profile already completed.');
        }

        Student::create([
            'user_id'    => $user->id,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
        ]);

        // Set session flag to NOT show popup anymore
        session()->flash('profile_completed', true);

        return redirect()->route('dashboard')->with('status', 'Profile completed successfully!');
    }
}
