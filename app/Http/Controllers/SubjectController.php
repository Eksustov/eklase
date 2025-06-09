<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::all(); // Or filter based on user, if needed
        return view('subjects.index', compact('subjects'));
    }
}
