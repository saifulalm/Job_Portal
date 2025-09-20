<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profil {{ $alumnus->user->name }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gray-50">
<div class="relative min-h-screen flex flex-col">
    <header class="sticky top-0 bg-white shadow-sm z-20 border-b border-gray-200">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex-shrink-0">
                    <a href="{{ route('alumni.index') }}" class="text-2xl font-bold text-gray-800">🎓 <span class="text-red-600">Direktori</span> Alumni</a>
                </div>
                <nav class="hidden md:flex items-center gap-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-red-600 font-medium transition-colors duration-300">Dasbor</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-red-600 font-medium transition-colors duration-300">Masuk</a>
                            <a href="{{ route('register.company') }}" class="px-4 py-2 rounded-md bg-red-600 text-white hover:bg-red-700 transition-colors duration-300 font-semibold shadow-sm">Daftar Perusahaan</a>
                        @endauth
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <main class="flex-1 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 mb-8"> {{-- Added mb-8 here --}}

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-8 shadow-md" role="alert">
                    <p class="font-bold">Sukses</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                {{-- SECTION: Profile Header --}}
                <div class="relative">
                    <div class="h-40 bg-gradient-to-r from-gray-700 via-gray-800 to-black"></div>

                    <div class="absolute left-1/2 transform -translate-x-1/2 -translate-y-1/2 top-40">
                        {{-- Enhanced Profile Picture --}}
                        <div class="w-36 h-36 rounded-full overflow-hidden ring-4 ring-white shadow-xl transform transition-all duration-300 hover:scale-105">
                            <img src="{{ $alumnus->photo_url }}" alt="Foto profil {{ $alumnus->user->name }}" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                <div class="text-center pt-20 pb-8 px-6">
                    <h1 class="text-4xl font-bold text-gray-900">{{ $alumnus->user->name }}</h1>
                    <p class="text-lg text-red-600 font-semibold mt-1">{{ $alumnus->job_title ?? 'Alumni' }}</p>
                </div>

                {{-- SECTION: Profile Details --}}
                <div class="p-8 border-t border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-12">
                    <div class="md:col-span-2 space-y-10">

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Posisi Saat Ini</h3>
                                <div class="mt-3 space-y-2 text-gray-600">
                                    <p><strong>Perusahaan:</strong> {{ $alumnus->company_name ?? 'Tidak Ditentukan' }}</p>
                                    <p><strong>Lokasi:</strong> {{ $alumnus->company_address ?? 'Tidak Ditentukan' }}</p>
                                    <p class="mt-2 text-gray-500 italic">{{ $alumnus->job_description ?? 'Tidak ada deskripsi pekerjaan.' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 14l9-5-9-5-9 5 9 5z" /><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-5.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222 4 2.222V20" /></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Pendidikan</h3>
                                <div class="mt-3 space-y-2 text-gray-600">
                                    <p><strong>Universitas:</strong> {{ $alumnus->university_name }}</p>
                                    <p><strong>Jurusan:</strong> {{ $alumnus->major }} ({{ $alumnus->degree }})</p>
                                    <p><strong>Lulus:</strong> {{ $alumnus->graduation_year }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-12 h-12 bg-red-100 text-red-600 rounded-lg flex items-center justify-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Beasiswa</h3>
                                <div class="mt-3 space-y-2 text-gray-600">
                                    <p><strong>Program:</strong> {{ $alumnus->scholarship_name }}</p>
                                    <p><strong>Periode:</strong> {{ $alumnus->scholarship_start_year ?? 'N/A' }} - {{ $alumnus->scholarship_end_year ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border h-fit shadow-sm">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Hubungi Alumni</h3>
                        <div class="space-y-4">
                            <p class="text-gray-600 flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <span class="truncate">{{ $alumnus->user->email }}</span>
                            </p>
                            <p class="text-gray-600 flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>{{ $alumnus->phone_number ?? 'Tidak Diberikan' }}</span>
                            </p>
                        </div>

                        <div class="border-t my-6"></div>

                        @auth
                            @if(auth()->user()->role === 'company')
                                <form action="{{ route('alumni.contact', $alumnus->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-center block px-4 py-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        Tunjukkan Minat (Wawancara)
                                    </button>
                                </form>
                                <p class="text-xs text-center text-gray-500 mt-3">Alumni akan menerima notifikasi minat Anda.</p>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full text-center block px-4 py-3 rounded-lg bg-gray-800 text-white font-semibold hover:bg-gray-700 transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Masuk sebagai Perusahaan
                            </a>
                            <p class="text-xs text-center text-gray-500 mt-3">Login untuk dapat menghubungi alumni.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
