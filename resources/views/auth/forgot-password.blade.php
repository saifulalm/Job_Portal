<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased font-sans">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center p-4">

    <!-- Laracon Style Icon -->
    <div class="mb-8">
        <a href="/">
            <svg class="h-12 w-12 text-gray-400 dark:text-gray-600 transition-colors duration-300 hover:text-red-500" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                <path d="M24.7,3.12,5.2,13.34V33.78l19.5,10.22,19.5-10.22V13.34Zm0,3.87,15.6,8.18-7.8,4.09-15.6-8.18Zm-15.6,10,7.8,4.09-7.8,4.09Zm19.5,18.4-15.6-8.18,7.8-4.09,15.6,8.18Zm7.8-14.31-7.8-4.09,7.8-4.09V25.2Z"/>
            </svg>
        </a>
    </div>

    <div class="max-w-4xl w-full mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden grid md:grid-cols-2 transition-all duration-300 hover:shadow-3xl">

        {{-- Left Panel: Branding & Message (Hidden on mobile) --}}
        <div class="p-8 md:p-12 bg-gray-800 text-white hidden md:flex flex-col justify-center">
            <div class="flex-shrink-0">
                <a href="/" class="text-3xl font-bold">
                    🎓 <span class="text-red-500">Direktori</span> Alumni
                </a>
            </div>
            <h2 class="mt-8 text-3xl font-bold leading-tight">Forgot Your Password?</h2>
            <p class="mt-4 text-gray-300">
                No problem. Enter your email address and we'll send you a link to reset it.
            </p>
        </div>

        {{-- Right Panel: Forgot Password Form --}}
        <div class="p-6 sm:p-8 md:p-12">
            {{-- Mobile-only Branding --}}
            <div class="md:hidden mb-6 text-center">
                <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                    🎓 <span class="text-red-500">Direktori</span> Alumni
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Reset Password</h2>
            <div class="mt-6">
                <div class="mb-4 text-sm text-gray-600 dark:text-gray-400 text-center md:text-left">
                    {{ __('Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 gap-4">
                        <a href="{{ route('login') }}" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800 order-2 sm:order-1">
                            {{ __('Back to login') }}
                        </a>
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 order-1 sm:order-2">
                            {{ __('Send Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>

