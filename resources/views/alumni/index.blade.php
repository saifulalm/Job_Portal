<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Direktori Alumni</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for oval images and center alignment */
        .profile-photo {
            width: 300px;
            height: 400px;
            object-fit: cover;
            border-radius: 50% / 40%;
            margin-left: auto;
            margin-right: auto;
            display: block;
        }

        .profile-card {
            text-align: center;
            padding: 1rem;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        .profile-name {
            font-weight: 700;
            font-size: 0.875rem; /* slightly bigger */
            margin-top: 0.75rem;
        }

        .profile-job {
            font-size: 0.75rem;
            color: #ef4444; /* Tailwind red-500 */
            margin-top: 0.25rem;
        }

        .profile-university {
            font-size: 0.7rem;
            color: #64748b; /* Tailwind slate-500 */
            margin-top: 0.25rem;
        }

        .profile-link {
            font-size: 0.75rem;
            color: #ef4444; /* Tailwind red-500 */
            margin-top: 0.75rem;
            display: inline-block;
            cursor: pointer;
            text-decoration: underline;
        }

        /* Responsive grid layout */
        .grid-container {
            display: grid;
            gap: 28px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            padding: 2rem 1rem;
            justify-items: center;
        }

        /* Header and main container padding */
        main {
            padding-bottom: 4rem;
        }
    </style>
</head>
<body class="antialiased font-sans bg-white">
<div class="relative min-h-screen flex flex-col">
    <!-- Header -->
    <header class="sticky top-0 bg-white shadow-md z-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('alumni.index') }}" class="text-2xl font-bold text-gray-800">
                        🎓 <span class="text-red-600">Direktori</span> Alumni
                    </a>
                </div>
                <nav class="hidden md:flex items-center gap-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-red-600 font-medium">Dasbor</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 font-medium">Masuk</a>
                            <a href="{{ route('register.company') }}" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors font-semibold">Daftar Perusahaan</a>
                        @endauth
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Konten Utama -->
    <main class="flex-1">
        <div class="bg-white py-12 border-b">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <h1 class="text-4xl font-extrabold text-gray-900 text-center">Temukan Alumni Berbakat Kami</h1>
                <p class="mt-2 text-lg text-gray-600 text-center max-w-2xl mx-auto">
                    Cari kandidat sempurna berdasarkan nama, jurusan, universitas, atau posisi saat ini.
                </p>

                <!-- Form Pencarian -->
                <form action="{{ route('alumni.index') }}" method="GET" class="mt-8 max-w-xl mx-auto">
                    <div class="flex items-center border-2 border-gray-200 rounded-full shadow-inner overflow-hidden">
                        <input type="text" name="search" placeholder="Contoh: Juliet Pamela atau Hubungan Internasional..."
                               class="flex-grow p-4 border-0 focus:ring-0 text-gray-700" value="{{ request('search') }}">
                        <button type="submit" class="px-6 py-4 bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Grid Alumni -->
        <div class="bg-white py-16">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                @if($alumni->isEmpty())
                    <div class="text-center py-16">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Alumni Tidak Ditemukan</h3>
                        <p class="mt-1 text-sm text-gray-500">Tidak ada profil alumni yang cocok dengan kriteria pencarian Anda. Coba pencarian lain.</p>
                    </div>
                @else
                    <div class="grid-container">
                        @foreach($alumni as $profile)
                            <div class="profile-card">
                                <img src="{{ $profile->photo_url }}" alt="Foto profil {{ $profile->user->name }}" class="profile-photo" />
                                <h3 class="profile-name">{{ $profile->user->name }}</h3>
                                <p class="profile-job">{{ $profile->job_title ?? 'Alumni' }}</p>
                                <p class="profile-university">{{ $profile->university_name }}</p>
                                <a href="{{ route('alumni.show', $profile->id) }}" class="profile-link">Lihat Profil</a>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="mt-12 text-center">
                        {{ $alumni->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </main>
</div>
</body>
</html>
