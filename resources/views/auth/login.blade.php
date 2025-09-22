<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* 3D Flip-in animation for the form card */
        @keyframes flipIn {
            from {
                transform: rotateY(-70deg) translateZ(150px);
                opacity: 0;
            }
            to {
                transform: rotateY(0) translateZ(0);
                opacity: 1;
            }
        }
        .perspective-container {
            perspective: 1000px;
        }
        .animate-flipIn {
            transform-style: preserve-3d;
            animation: flipIn 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }
        .form-card {
            transform: rotateY(-70deg) translateZ(150px);
            opacity: 0;
        }
    </style>
</head>
<body class="antialiased font-sans">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center p-4 perspective-container">

    <!-- Laracon Style Icon -->
    <div class="mb-8">
        <a href="/">
            <svg class="h-12 w-12 text-gray-400 dark:text-gray-600 transition-colors duration-300 hover:text-red-500" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.7,3.12,5.2,13.34V33.78l19.5,10.22,19.5-10.22V13.34Zm0,3.87,15.6,8.18-7.8,4.09-15.6-8.18Zm-15.6,10,7.8,4.09-7.8,4.09Zm19.5,18.4-15.6-8.18,7.8-4.09,15.6,8.18Zm7.8-14.31-7.8-4.09,7.8-4.09V25.2Z"/>
            </svg>
        </a>
    </div>

    <div id="form-card" class="max-w-4xl w-full mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden grid md:grid-cols-2 transition-all duration-300 hover:shadow-3xl form-card">

        {{-- Left Panel: Branding & Message --}}
        <div class="p-8 md:p-12 bg-gray-800 text-white hidden md:flex flex-col justify-center">
            <div class="flex-shrink-0">
                <a href="/" class="text-3xl font-bold">
                    🎓 <span class="text-red-500">Direktori</span> Alumni
                </a>
            </div>
            <h2 class="mt-8 text-3xl font-bold leading-tight">Connect with a World of Talent.</h2>
            <p class="mt-4 text-gray-300">
                Log in to manage your job postings, discover talented alumni, and build your team.
            </p>
        </div>

        {{-- Right Panel: Login Form --}}
        <div class="p-6 sm:p-8 md:p-12">
            {{-- Mobile-only Branding --}}
            <div class="md:hidden mb-6 text-center">
                <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                    🎓 <span class="text-red-500">Direktori</span> Alumni
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Company Login</h2>
            <p class="mt-2 text-sm text-center text-gray-600 dark:text-gray-400">
                Don't have an account? <a href="{{ route('register.company') }}" class="font-medium text-red-600 hover:text-red-500">Sign up</a>
            </p>

            <div class="mt-6">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300"/>
                        <x-text-input id="password" class="block mt-1 w-full"
                                      type="password"
                                      name="password"
                                      required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Log in') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add 3D flip animation on load
        const formCard = document.getElementById('form-card');
        setTimeout(() => {
            formCard.classList.add('animate-flipIn');
        }, 100);
    });
</script>
</body>
</html>

