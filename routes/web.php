<?php

use App\Http\Controllers\ConfirmController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin routes (users with manage-users permission)
Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::get('/admins', fn() => view('adminFiles.dashboard'))->name('admins.index');
});

// Teacher routes (users with interact-with-students permission)
Route::middleware(['auth', 'can:interact-with-students'])->group(function () {
    Route::get('/teachers', fn() => view('teacher.dashboard'))->name('teachers.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
});

Route::middleware(['auth', 'can:manage-users'])->group(function () {
    Route::resource('/subjects', SubjectController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/confirm', [ConfirmController::class, 'index'])->name('confirm');
    Route::post('/confirm', [ConfirmController::class, 'store'])->name('confirm.store');
});

Route::middleware(['auth'])->post('/students/store', [StudentController::class, 'store'])->name('students.store');

// Profile routes for any authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
