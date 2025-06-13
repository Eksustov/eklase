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

        // Redirect if NOT a student
        if (!$user->hasRole('student')) {
            return redirect()->route('dashboard')->with('error', 'Access denied.');
        }

        // Redirect if student already completed profile
        if (Student::where('user_id', $user->id)->exists()) {
            return redirect()->route('dashboard');
        }

        // Show confirm view
        return view('confirm');
    }
}
