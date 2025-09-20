<?php


namespace App\Http\Controllers;

use App\Models\AlumniProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AlumniInterestMail;

// Pastikan Anda sudah membuat Mailable ini
use App\Models\User;

class AlumniController extends Controller
{
    /**
     * Menampilkan halaman utama direktori yang berisi daftar semua profil alumni.
     * Metode ini juga menangani fungsionalitas pencarian dan paginasi.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Mulai query dasar dengan memuat relasi 'user' untuk efisiensi (Eager Loading).
        $query = AlumniProfile::with('user');

        // Periksa apakah ada input pencarian di URL.
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            // Terapkan filter pencarian ke query.
            $query->where(function ($q) use ($searchTerm) {
                // Cari di dalam nama user yang berelasi.
                $q->whereHas('user', function ($userQuery) use ($searchTerm) {
                    $userQuery->where('name', 'like', "%{$searchTerm}%");
                })
                    // Atau cari di kolom-kolom lain di dalam tabel profil.
                    ->orWhere('major', 'like', "%{$searchTerm}%")
                    ->orWhere('university_name', 'like', "%{$searchTerm}%")
                    ->orWhere('job_title', 'like', "%{$searchTerm}%");
            });
        }

        // Ambil hasil query, urutkan berdasarkan yang terbaru, dan bagi menjadi halaman-halaman (12 profil per halaman).
        $alumni = $query->latest()->paginate(12);

        // Kembalikan view 'alumni.index' dan kirimkan data alumni yang sudah dipaginasi.
        return view('alumni.index', compact('alumni'));
    }

    /**
     * Menampilkan halaman detail untuk satu profil alumni yang spesifik.
     * Menggunakan Route-Model Binding untuk secara otomatis menemukan alumni dari ID di URL.
     *
     * @param \App\Models\AlumniProfile $alumnus
     * @return \Illuminate\View\View
     */
    public function show(AlumniProfile $alumnus)
    {
        // Muat relasi 'user' untuk memastikan data user tersedia di view.
        $alumnus->load('user');

        // Kembalikan view 'alumni.show' dan kirimkan data alumni tunggal.
        return view('alumni.show', compact('alumnus'));
    }

    /**
     * Menangani pengiriman email "ketertarikan" dari perusahaan yang login ke alumni.
     *
     * @param \App\Models\AlumniProfile $alumnus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function contact(AlumniProfile $alumnus)
    {
        // Dapatkan user yang sedang login (yang seharusnya adalah perusahaan).
        $company = auth()->user();

        // Pastikan data user dari alumni sudah dimuat.
        $alumnus->load('user');

        // Kirim email ke alamat email alumni.
        // Ini menggunakan kelas Mailable 'AlumniInterestMail' yang perlu Anda buat.
        Mail::to($alumnus->user->email)->send(new AlumniInterestMail($alumnus, $company));

        // Redirect kembali ke halaman profil dengan pesan sukses.
        return redirect()->back()->with('success', 'Email ketertarikan Anda telah berhasil dikirim ke ' . $alumnus->user->name);
    }
}
