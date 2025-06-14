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
    Route::get('/teachers', function () {
        $subjects = Subject::all();
        $students = Student::with('user')->get();  // eager load user if you want
        return view('teacher.dashboard', compact('subjects', 'students'));
    })->middleware(['auth'])->name('teachers.index');
    Route::get('/grades/create', [GradeController::class, 'create'])->name('grades.create');
    Route::post('/grades', [GradeController::class, 'store'])->name('grades.store');
    Route::resource('grades', GradeController::class);
    Route::get('/subjects/{subject}/grades', [GradeController::class, 'gradesBySubject'])->name('grades.bySubject');
    Route::get('/students/{student}/grades', [GradeController::class, 'gradesByStudent'])->name('grades.byStudent');
    Route::delete('/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
});

// Student
Route::middleware(['auth', 'can:view-self'])->group(function () {
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/my-grades', [\App\Http\Controllers\GradeController::class, 'myGrades'])->name('grades.my');

});

// Subjects
Route::middleware(['auth'])->group(function () {
    Route::resource('/subjects', SubjectController::class)->except(['show']);
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
});

require __DIR__.'/auth.php';
