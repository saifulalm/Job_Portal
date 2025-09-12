<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Alumni Job Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans bg-gradient-to-b from-gray-50 to-white">
<div class="relative min-h-screen flex flex-col">
    <!-- Header -->
    <header class="flex items-center justify-between px-6 py-6 lg:px-12 shadow-sm bg-white">
        <div class="flex items-center gap-2">
            <!-- Logo -->
            <span class="text-2xl font-bold text-red-600">🎓 Alumni Job Portal</span>
        </div>
        <nav class="flex items-center gap-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="text-gray-700 hover:text-red-600 font-medium">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                        Log in
                    </a>
                    <a href="{{ route('register.employee') }}"
                       class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
                        Register as Employee
                    </a>
                    <a href="{{ route('register.company') }}"
                       class="px-4 py-2 rounded-lg bg-gray-900 text-white hover:bg-gray-800 transition">
                        Register as Company
                    </a>
                @endauth
            @endif
        </nav>
    </header>

    <!-- Hero Section -->
    <main class="flex-1 flex flex-col justify-center items-center text-center px-6 lg:px-12">
        <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 leading-tight">
            Find Your <span class="text-red-600">Dream Job</span> or <br>Hire the Best Alumni Talent
        </h1>
        <p class="mt-4 text-lg text-gray-600 max-w-2xl">
            Whether you’re a graduate looking for opportunities or a company searching for skilled alumni, we connect the right people together.
        </p>

        <!-- CTA Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4">
            <a href="{{ route('register.employee') }}"
               class="px-6 py-3 rounded-xl bg-red-600 text-white font-semibold hover:bg-red-700 transition">
                I’m Looking for a Job
            </a>
            <a href="{{ route('register.company') }}"
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-semibold hover:bg-gray-800 transition">
                I’m Hiring Alumni
            </a>
        </div>

        <!-- Illustration (optional, can use an image or SVG) -->
        <div class="mt-12">
            <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png"
                 alt="Job Search Illustration" class="w-64 mx-auto opacity-90">
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-6 text-center text-sm text-gray-500 border-t">
        Powered by Laravel v{{ Illuminate\Foundation\Application::VERSION }}
        (PHP v{{ PHP_VERSION }})
    </footer>
</div>
</body>
</html>
