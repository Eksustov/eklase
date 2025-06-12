<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profileCompleted = Student::where('user_id', $user->id)->exists();

        return view('dashboard', [
            'profileCompleted' => $profileCompleted
        ]);
    }
}
