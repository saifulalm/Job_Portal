<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Menampilkan formulir untuk mengedit profil alumni yang sedang login.
     */
    public function edit(Request $request)
    {
        // Ambil profil alumni yang terhubung dengan user yang sedang login.
        $alumnus = $request->user()->alumniProfile;

        // Tampilkan view formulir edit dan kirimkan data profil.
        return view('alumni.profile.edit', compact('alumnus'));
    }

    /**
     * Memperbarui profil alumni di dalam database.
     */
    public function update(Request $request)
    {
        // Ambil profil alumni dari user yang sedang login.
        $profile = $request->user()->alumniProfile;

        // Validasi data yang masuk dari formulir.
        $validatedData = $request->validate([
            'phone_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:512',
            'province' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'job_status' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:100',
            'company_address' => 'nullable|string|max:512',
            'job_title' => 'nullable|string|max:100',
            'job_description' => 'nullable|string',
            'linkedin_profile' => 'nullable|url|max:255',
            'facebook_profile' => 'nullable|url|max:255',
            'instagram_profile' => 'nullable|url|max:255',
            'twitter_profile' => 'nullable|url|max:255',
            'vision_mission' => 'nullable|string',
        ]);

        // Perbarui profil dengan data yang sudah divalidasi.
        $profile->update($validatedData);

        // Redirect kembali ke halaman edit dengan pesan sukses.
        return redirect()->route('alumni.profile.edit')->with('success', 'Profil Anda telah berhasil diperbarui!');
    }
}
