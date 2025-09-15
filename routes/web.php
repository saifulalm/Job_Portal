<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

// --- PUBLIC ROUTES (Visible to everyone) ---

// Route 1: The Homepage
// The root URL ('/') now directly shows the job list by calling the 'index' method on JobController.
Route::get('/', [JobController::class, 'index'])->name('home');

// Route 2: Job Board Routes
// These handle the public job listings.
Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index'); // Also shows the job list.
Route::get('/jobs/{job}', [JobController::class, 'show'])->name('jobs.show'); // Shows a single job's details.

// Route 3: Custom Registration Routes
// These provide separate registration pages for different user types.
Route::get('register/alumni', [RegisteredUserController::class, 'createAlumni'])
    ->middleware('guest') // Only guests can see this.
    ->name('register.alumni');

Route::get('register/company', [RegisteredUserController::class, 'createCompany'])
    ->middleware('guest')
    ->name('register.company');

// Route 4: Standard Authentication Routes
// This file includes all the default routes for login, logout, password reset, etc.
require __DIR__.'/auth.php';

// Route 5: Secret Admin Login
// This creates a non-public URL for admins to log in. It uses the same login controller
// but has a unique name and path.
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('admin.login');


// --- PROTECTED ROUTES (Require user to be logged in) ---
Route::middleware(['auth'])->group(function () {

    // Group A: Admin Routes
    // This group is protected by the 'is.admin' middleware.
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    });

    // Group B: Company Routes
    // Protected by 'is.company' middleware. The prefix adds '/company' to all URLs inside.
    Route::middleware('is.company')->prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', fn() => view('company.dashboard'))->name('dashboard');
        Route::resource('jobs', CompanyJobController::class); // Creates all CRUD routes for jobs.
    });

    // Group C: Alumni Routes
    // Protected by 'is.alumni' middleware.
    Route::middleware('is.alumni')->prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    });

    // The Main Redirect Dashboard
    // After logging in, this route checks the user's role and sends them to the correct dashboard.
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'company') return redirect()->route('company.dashboard');
        return redirect()->route('alumni.dashboard');
    })->name('dashboard');

    // User Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

