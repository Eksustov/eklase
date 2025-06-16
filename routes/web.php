<?php

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GradeController;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfilePictureController;

// Welcome
Route::get('/', fn() => view('welcome'));

// Dashboard
Route::get('/dashboard', function () {
    $user = Auth::user();
    $profileCompleted = false;

    if ($user->hasRole('student')) {
        $profileCompleted = Student::where('user_id', $user->id)->exists();
    }

    return view('dashboard', compact('profileCompleted'));
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin
Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::get('/admins', fn() => view('adminFiles.dashboard'))->name('admins.index');
});

// Teacher
Route::middleware(['auth', 'can:interact-with-students'])->group(function () {
    Route::get('/teachers', function (Request $request) {
        // Subjects search & sort
        $subjectQuery = Subject::query();

        if ($request->filled('subject_search')) {
            $subjectQuery->where('name', 'like', '%' . $request->subject_search . '%');
        }

        if ($request->filled('subject_sort')) {
            $subjectQuery->orderBy('name', $request->subject_sort);
        }

        $subjects = $subjectQuery->get();

        // Students search & sort
        $studentQuery = Student::with('user');

        if ($request->filled('student_search')) {
            $studentQuery->whereHas('user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->student_search . '%')
                ->orWhere('last_name', 'like', '%' . $request->student_search . '%');
            });
        }

        if ($request->filled('student_sort')) {
            $studentQuery->join('users', 'students.user_id', '=', 'users.id')
                        ->orderBy('users.first_name', $request->student_sort)
                        ->select('students.*'); // ensure only student columns are selected
        }

        $students = $studentQuery->get();

        return view('teacher.dashboard', compact('subjects', 'students'));
    })->middleware(['auth'])->name('teachers.index');

    Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
    Route::resource('grades', GradeController::class);
    Route::get('/grades/subject/{subject}', [GradeController::class, 'gradesBySubject'])->name('grades.bySubject');
    Route::get('/grades/student/{student}', [GradeController::class, 'gradesByStudent'])->name('grades.byStudent');
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
});

// Student
Route::middleware(['auth', 'can:view-self'])->group(function () {
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/my-grades', [\App\Http\Controllers\GradeController::class, 'myGrades'])->name('grades.my');
    Route::get('/grades/export/pdf', [GradeController::class, 'exportPdf'])->name('grades.export.pdf');
});

// Subjects
Route::middleware(['auth'])->group(function () {
    Route::resource('/subjects', SubjectController::class)->except(['show']);
    Route::get('/subjects/{subject}/grades', [GradeController::class, 'showSubjectGrades'])->name('subjects.grades.show');
});

// Confirm
Route::middleware(['auth'])->group(function () {
    Route::get('/confirm', [ConfirmController::class, 'index'])->name('confirm');
    Route::post('/confirm', [ConfirmController::class, 'store'])->name('confirm.store');
});

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile-picture', [ProfilePictureController::class, 'update'])->name('profile-picture.update');
});

require __DIR__.'/auth.php';

