<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AlumniProfile extends Model
{
    /**
     * Atribut yang tidak diizinkan untuk diisi secara massal.
     * Menggunakan 'guarded' adalah praktik yang aman ketika Anda memiliki banyak kolom
     * dan ingin mengizinkan pengisian untuk semuanya kecuali primary key 'id'.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Mendefinisikan relasi bahwa sebuah profil dimiliki oleh satu user (one-to-one).
     * Ini memungkinkan kita untuk dengan mudah mengakses informasi user seperti nama dan email
     * dari objek profil dengan menggunakan `$profil->user->name`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ini adalah "Accessor" kustom untuk atribut 'photo_url'.
     * Metode ini akan berjalan secara otomatis setiap kali Anda mencoba mengakses `$alumnus->photo_url`
     * di dalam file view (Blade) atau di tempat lain di kode Anda.
     *
     * Logikanya adalah memuat foto dari penyimpanan lokal Anda yang sudah diunduh.
     *
     * @return string URL publik ke foto alumni.
     */
    public function getPhotoUrlAttribute(): string
    {
        // Langkah 1: Periksa apakah kolom 'photo_path' di database berisi data
        //            DAN apakah file yang ditunjuk oleh path tersebut benar-benar ada
        //            di dalam disk penyimpanan 'public' (folder storage/app/public).
        if ($this->photo_path && Storage::disk('public')->exists($this->photo_path)) {
            // Langkah 2: Jika kedua kondisi terpenuhi, buat dan kembalikan URL publik
            //            ke file tersebut. Ini akan menghasilkan URL seperti 'http://127.0.0.1:8000/storage/photos/namafile.jpg'.
            return Storage::disk('public')->url($this->photo_path);
        }

        // Langkah 3: Jika salah satu kondisi di atas gagal (path kosong atau file tidak ditemukan),
        //            kembalikan URL ke avatar pengganti yang aman.
        return $this->generateDefaultPhoto();
    }

    /**
     * Fungsi bantuan pribadi untuk membuat URL avatar default.
     * Ini digunakan sebagai fallback jika foto asli tidak tersedia.
     *
     * @return string URL ke layanan ui-avatars.com.
     */
    private function generateDefaultPhoto(): string
    {
        // Ambil nama dari relasi user jika ada, jika tidak gunakan 'Alumni' sebagai default.
        $name = $this->user ? $this->user->name : 'Alumni';

        // Buat URL yang akan menghasilkan gambar PNG dengan inisial nama.
        return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF&bold=true';
    }
}

