<?php

namespace App\Console\Commands;

use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SyncAlumniData extends Command
{
    /**
     * Nama dan signature dari perintah konsol.
     *
     * @var string
     */
    protected $signature = 'alumni:sync';

    /**
     * Deskripsi dari perintah konsol.
     *
     * @var string
     */
    protected $description = 'Ambil, sinkronkan, dan unduh foto alumni dari database lama.';

    /**
     * Menjalankan logika perintah.
     */
    public function handle()
    {
        $this->info('Memulai sinkronisasi data alumni...');

        try {
            // Ambil semua data dari tabel 'alumni' di koneksi database lama.
            $oldAlumniData = DB::connection('mysql_old')->table('alumni')->get();
        } catch (\Exception $e) {
            $this->error('Tidak dapat terhubung ke database lama: ' . $e->getMessage());
            return 1; // Keluar dengan kode error
        }

        if ($oldAlumniData->isEmpty()) {
            $this->warn('Tidak ada data ditemukan. Tidak ada yang disinkronkan.');
            return 0; // Keluar dengan sukses
        }

        // Buat progress bar untuk memberikan feedback visual di terminal.
        $bar = $this->output->createProgressBar($oldAlumniData->count());
        $bar->start();

        foreach ($oldAlumniData as $oldData) {
            // Gunakan transaksi database untuk memastikan integritas data untuk setiap alumni.
            // Jika ada yang gagal, semua perubahan untuk alumni ini akan dibatalkan.
            DB::transaction(function () use ($oldData) {
                // Cari user berdasarkan email atau buat user baru jika belum ada.
                $user = User::updateOrCreate(
                    ['email' => $oldData->Email],
                    ['name' => $oldData->Nama, 'password' => Hash::make('password'), 'role' => 'alumni']
                );

                // Buat atau perbarui profil alumni yang terhubung dengan user.
                $profile = AlumniProfile::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'old_alumni_id' => $oldData->AlumniID,
                        'gender' => $oldData->Jenis_Kelamin,
                        'date_of_birth' => $oldData->Tanggal_Lahir,
                        'phone_number' => $oldData->NoTelp,
                        'address' => $oldData->AlamatDomisili,
                        'province' => $oldData->AsalProvinsi,
                        'scholarship_name' => $oldData->NamaProgramBeasiswa,
                        'scholarship_start_year' => $this->parseYear($oldData->Tahun_Mulai_Beasiswa),
                        'scholarship_end_year' => $this->parseYear($oldData->Tahun_Akhir_Beasiswa),
                        'university_name' => $oldData->Nama_Universitas,
                        'major' => $oldData->Jurusan,
                        'degree' => $oldData->Jenjang_Kuliah,
                        'graduation_year' => $this->parseYear($oldData->Tahun_Wisuda),
                        'photo_path' => null, // Set null dulu, akan diisi setelah diunduh
                        'job_status' => $oldData->Status_Pekerjaan,
                        'company_name' => $oldData->Nama_Perusahaan,
                        'job_title' => $oldData->Jabatan,
                        'job_description' => $oldData->JobDesc,
                        'linkedin_profile' => $oldData->LinkedInProfile,
                        'facebook_profile' => $oldData->FacebokProfile,
                        'instagram_profile' => $oldData->Instagram,
                        'twitter_profile' => $oldData->Twitter,
                        'company_address' => $oldData->Alamat_Perusahaan,
                        'city' => $oldData->KabKota,
                        'country' => $oldData->Negara,
                        'state' => $oldData->Negara_Bagian,
                        // 'ethnicity' => $oldData->Suku, // Kolom ini tidak ada di tabel baru
                        'vision_mission' => $oldData->Visi_Target,
                    ]
                );

                // Panggil fungsi untuk mengunduh dan menyimpan foto.
                $this->downloadAndSavePhoto($profile);
            });

            // Lanjutkan progress bar.
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nSinkronisasi data alumni selesai dengan sukses.");
        return 0;
    }

    /**
     * Fungsi bantuan untuk mengubah nilai tanggal menjadi tahun dengan aman.
     *
     * @param mixed $dateValue Nilai dari database lama.
     * @return int|null Tahun dalam format integer, atau null jika tidak valid.
     */
    private function parseYear($dateValue): ?int
    {
        if (empty($dateValue)) return null;
        try {
            // Coba parsing tanggal dan ambil tahunnya.
            return \Carbon\Carbon::parse($dateValue)->year;
        } catch (\Exception $e) {
            // Jika parsing gagal, catat sebagai peringatan dan kembalikan null.
            Log::warning("Tidak dapat mem-parsing tanggal: " . $dateValue);
            return null;
        }
    }

    /**
     * Mengunduh foto dari API berdasarkan ID alumni lama dan menyimpannya secara lokal.
     *
     * @param AlumniProfile $profile Objek profil alumni yang akan diproses.
     */
    private function downloadAndSavePhoto(AlumniProfile $profile): void
    {
        if (empty($profile->old_alumni_id)) {
            return;
        }

        try {
            $apiUrl = "https://pssp.dev/photos/view/{$profile->old_alumni_id}";
            $response = Http::timeout(10)->get($apiUrl); // Timeout 10 detik

            // Periksa apakah API merespons dengan sukses dan URL foto ada.
            if ($response->successful() && !empty($response->json()['data']['photo_url'])) {
                $photoUrl = $response->json()['data']['photo_url'];

                // Ambil konten (binary) dari gambar.
                $imageContents = Http::get($photoUrl)->body();

                // Buat nama file yang unik dan acak untuk menghindari konflik.
                $fileName = 'photos/' . Str::random(40) . '.' . pathinfo($photoUrl, PATHINFO_EXTENSION);

                // Simpan file ke disk 'public' (di dalam folder storage/app/public/photos).
                Storage::disk('public')->put($fileName, $imageContents);

                // Perbarui kolom photo_path di database dengan path lokal yang baru.
                $profile->photo_path = $fileName;
                $profile->save();
            }
        } catch (\Exception $e) {
            // Jika terjadi error (misalnya, timeout), catat di log agar tidak menghentikan proses.
            Log::error("Gagal mengunduh foto untuk old_alumni_id {$profile->old_alumni_id}: " . $e->getMessage());
        }
    }
}

