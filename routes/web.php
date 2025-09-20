<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use Illuminate\Support\Facades\Route;

// === RUTE PUBLIK ===
Route::get('/', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/{alumnus}', [AlumniController::class, 'show'])->name('alumni.show');

// Rute Pendaftaran
Route::get('register/alumni', [RegisteredUserController::class, 'createAlumni'])->middleware('guest')->name('register.alumni');
Route::get('register/company', [RegisteredUserController::class, 'createCompany'])->middleware('guest')->name('register.company');

// Rute Login Admin Rahasia
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');

// === RUTE YANG DILINDUNGI (MEMERLUKAN LOGIN) ===
Route::middleware(['auth'])->group(function() {
    Route::post('/alumni/{alumnus}/contact', [AlumniController::class, 'contact'])->middleware('is.company')->name('alumni.contact');

    // Rute Perusahaan
    Route::middleware('is.company')->prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', fn() => view('company.dashboard'))->name('dashboard');
        Route::resource('jobs', CompanyJobController::class);
    });

    // Rute Alumni
    Route::middleware('is.alumni')->prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');
    });
});

// Memuat rute-rute otentikasi standar dari Laravel Breeze
require __DIR__.'/auth.php';
