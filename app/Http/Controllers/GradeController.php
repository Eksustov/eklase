<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function create()
    {
        $students = Student::with('user')->get();
        $subjects = Subject::all();

        return view('grades.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|integer|min:1|max:10',
        ]);

        Grade::updateOrCreate(
            ['student_id' => $validated['student_id'], 'subject_id' => $validated['subject_id']],
            ['grade' => $validated['grade']]
        );

        return redirect()->route('grades.create')->with('success', 'Grade saved successfully.');
    }
}

