<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::get('/admins', function () {
        return view('adminFiles.dashboard'); // views/admin/dashboard.blade.php
    })->name('admins.index');
});

// Teacher-only routes
Route::middleware(['auth', 'can:interact-with-students'])->group(function () {
    Route::get('/teachers', function () {
        return view('teacher.dashboard'); // views/teacher/dashboard.blade.php
    })->name('teachers.index');
});

// Student-only route
Route::middleware(['auth', 'can:view-self'])->group(function () {
    Route::get('/students', function () {
        return view('student.dashboard'); // views/student/dashboard.blade.php
    })->name('students.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
