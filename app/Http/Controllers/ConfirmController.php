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
            return redirect()->route('dashboard');
        }
        return view('confirm');
    }
}
