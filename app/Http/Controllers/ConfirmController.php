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

        // If user is NOT a student OR already has profile, redirect back to dashboard
        if (!$user->hasRole('student', 'teacher', 'admin') || Student::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard')->with('status', 'You do not have access to the confirm page.');
        }

        // Otherwise show the confirm view
        return view('confirm');
    }
}
