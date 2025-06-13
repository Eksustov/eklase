<?php

use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfileController;

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
    Route::get('/teachers', fn() => view('teacher.dashboard'))->name('teachers.index');
});

// Student
Route::middleware(['auth', 'can:view-self'])->group(function () {
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
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
