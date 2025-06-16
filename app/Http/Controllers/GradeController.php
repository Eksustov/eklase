<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

        Grade::create($validated);

        return redirect()->route('grades.create')->with('success', 'Grade saved successfully.');
    }


    public function edit(Grade $grade, Request $request)
    {
        $students = Student::all();
        $subjects = Subject::all();
        $redirectTo = $request->input('redirect_to', route('grades.create')); // fallback

        return view('grades.edit', compact('grade', 'students', 'subjects', 'redirectTo'));
    }

    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|integer|min:1|max:10',
        ]);

        $grade->update([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
        ]);

        $redirectTo = $request->input('redirect_to', route('grades.create'));

        return redirect($redirectTo)->with('success', 'Grade updated successfully.');
    }


    public function myGrades()
    {
        $user = Auth::user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            abort(403, 'Not authorized or student profile not found.');
        }

        $grades = Grade::with('subject')
            ->where('student_id', $student->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('grades.my', compact('grades'));
    }

    public function gradesBySubject(Subject $subject)
    {
        $grades = Grade::with('student.user')
            ->where('subject_id', $subject->id)
            ->orderByDesc('created_at')
            ->get();

        return view('grades.by-subject', compact('grades', 'subject'));
    }

    public function gradesByStudent(Student $student)
    {
        $grades = Grade::with('subject')
            ->where('student_id', $student->id)
            ->orderByDesc('created_at')
            ->get();

        return view('grades.by-student', compact('grades', 'student'));
    }

    public function destroy(Request $request, Grade $grade)
    {
        $grade->delete();

        $redirectTo = $request->input('redirect_to', route('grades.create'));

        return redirect($redirectTo)->with('success', 'Grade deleted successfully.');
    }

    public function exportPdf()
    {
        $user = auth()->user();
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            abort(403, 'Not authorized or student profile not found.');
        }

        $grades = Grade::with('subject')
            ->where('student_id', $student->id)
            ->orderBy('created_at')
            ->get();

        return Pdf::loadView('grades.pdf', compact('grades'))
            ->download('my-grades.pdf');
    }

    
}

