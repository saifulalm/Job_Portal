<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Company\JobController as CompanyJobController;
use App\Http\Controllers\Alumni\ProfileController as AlumniProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User; // Ditambahkan untuk mengambil data statistik

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda bisa mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// === RUTE PUBLIK (Dapat diakses oleh semua orang) ===

// Halaman utama sekarang adalah direktori alumni.
Route::get('/', [AlumniController::class, 'index'])->name('alumni.index');

// Halaman untuk menampilkan detail satu profil alumni.
Route::get('/alumni/{alumnus}', [AlumniController::class, 'show'])->name('alumni.show');

// Rute pendaftaran kustom untuk setiap peran.
Route::get('register/alumni', [RegisteredUserController::class, 'createAlumni'])->middleware('guest')->name('register.alumni');
Route::get('register/company', [RegisteredUserController::class, 'createCompany'])->middleware('guest')->name('register.company');

// Rute login rahasia untuk admin.
Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])->name('admin.login');


// === RUTE YANG DILINDUNGI (Memerlukan login) ===
Route::middleware(['auth'])->group(function() {

    // Rute untuk perusahaan menghubungi alumni (memerlukan peran 'company').
    Route::post('/alumni/{alumnus}/contact', [AlumniController::class, 'contact'])->middleware('is.company')->name('alumni.contact');

    // --- Grup Rute Admin ---
    Route::middleware('is.admin')->prefix('admin')->name('admin.')->group(function () {
        // Rute dasbor admin yang mengambil data statistik.
        Route::get('/dashboard', function() {
            $alumniCount = User::where('role', 'alumni')->count();
            $companyCount = User::where('role', 'company')->count();
            return view('admin.dashboard', compact('alumniCount', 'companyCount'));
        })->name('dashboard');
    });

    // --- Grup Rute Perusahaan ---
    Route::middleware('is.company')->prefix('company')->name('company.')->group(function () {
        Route::get('/dashboard', fn() => view('company.dashboard'))->name('dashboard');
        // Route::resource secara otomatis membuat rute untuk create, read, update, delete.
        Route::resource('jobs', CompanyJobController::class);
    });

    // --- Grup Rute Alumni ---
    Route::middleware('is.alumni')->prefix('alumni')->name('alumni.')->group(function () {
        Route::get('/dashboard', fn() => view('alumni.dashboard'))->name('dashboard');
        Route::get('/profile', [AlumniProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [AlumniProfileController::class, 'update'])->name('profile.update');
    });
});

// Memuat semua rute otentikasi standar dari Laravel Breeze (login, logout, dll.).
require __DIR__.'/auth.php';
