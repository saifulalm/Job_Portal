<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel.
     *
     * @return void
     */
    public function up(): void
    {
        // Perintah ini akan membuat tabel baru bernama 'alumni_profiles'
        Schema::create('alumni_profiles', function (Blueprint $table) {
            $table->id(); // Kunci utama (primary key) auto-increment

            // Menghubungkan ke tabel 'users'. Jika user dihapus, profilnya juga akan dihapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Menyimpan ID asli dari database lama untuk referensi
            $table->integer('old_alumni_id')->unsigned()->nullable()->index();

            // Informasi Pribadi
            $table->string('gender', 10)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone_number', 50)->nullable();
            $table->string('address', 512)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('photo_path')->nullable(); // Path ke foto yang disimpan secara lokal

            // Informasi Beasiswa & Pendidikan
            $table->string('scholarship_name', 100)->nullable();
            $table->year('scholarship_start_year')->nullable();
            $table->year('scholarship_end_year')->nullable();
            $table->string('university_name')->nullable();
            $table->string('major')->nullable();
            $table->string('degree', 100)->nullable();
            $table->year('graduation_year')->nullable();

            // Informasi Karir
            $table->string('job_status')->nullable();
            $table->string('company_name', 100)->nullable();
            $table->string('company_address', 512)->nullable();
            $table->string('job_title', 100)->nullable();
            $table->text('job_description')->nullable();

            // Media Sosial & Visi
            $table->string('linkedin_profile')->nullable();
            $table->string('facebook_profile')->nullable();
            $table->string('instagram_profile')->nullable();
            $table->string('twitter_profile')->nullable();
            $table->text('vision_mission')->nullable();

            // Timestamps otomatis (created_at dan updated_at)
            $table->timestamps();
        });
    }

    /**
     * Membalikkan migrasi (menghapus tabel).
     *
     * @return void
     */
    public function down(): void
    {
        // Perintah ini akan menghapus tabel 'alumni_profiles' jika migrasi di-rollback.
        Schema::dropIfExists('alumni_profiles');
    }
};

