<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;

// Publicly accessible routes
Route::get('/', function () {
    // Later, this will be the main job listings page
    return view('welcome');
});

// Custom Registration Routes
Route::get('register/employee', [RegisteredUserController::class, 'createEmployee'])
    ->middleware('guest')
    ->name('register.employee');

Route::get('register/company', [RegisteredUserController::class, 'createCompany'])
    ->middleware('guest')
    ->name('register.company');


// Dashboard route that redirects based on role after login
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'company') {
        return redirect()->route('company.dashboard');
    } elseif ($user->role === 'employee') {
        return redirect()->route('employee.dashboard');
    }
    // Fallback, though should not be reached with proper roles
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// General authenticated user routes (like profile editing)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Role-specific route groups
Route::middleware(['auth', 'is.admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function() {
        return '<h1>Admin Dashboard</h1>';
    })->name('admin.dashboard');
});

Route::middleware(['auth', 'is.company'])->prefix('company')->group(function () {
    Route::get('/dashboard', function() {
        return '<h1>Company Dashboard</h1>';
    })->name('company.dashboard');
});

Route::middleware(['auth', 'is.employee'])->prefix('employee')->group(function () {
    Route::get('/dashboard', function() {
        return '<h1>Employee Dashboard</h1>';
    })->name('employee.dashboard');
});


// Include the default auth routes from Laravel Breeze
require __DIR__.'/auth.php';
