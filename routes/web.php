<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Students Dashboard
Route::middleware(['auth', 'can:view-students-dashboard'])->group(function () {
    Route::get('/students', fn() => view('student.dashboard'))->name('students.index');
});

// Teachers Dashboard
Route::middleware(['auth', 'can:view-teachers-dashboard'])->group(function () {
    Route::get('/teachers', fn() => view('teacher.dashboard'))->name('teachers.index');
});

// Admins Dashboard
Route::middleware(['auth', 'can:view-admins-dashboard'])->group(function () {
    Route::get('/admins', fn() => view('adminFiles.dashboard'))->name('admins.index');
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

