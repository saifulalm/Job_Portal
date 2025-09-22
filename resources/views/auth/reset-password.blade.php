<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Shake animation for the form card */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }
        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }
    </style>
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

    <div id="form-card" class="max-w-4xl w-full mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden grid md:grid-cols-2 transition-all duration-300 hover:shadow-3xl">

        {{-- Left Panel: Branding & Message --}}
        <div class="p-8 md:p-12 bg-gray-800 text-white hidden md:flex flex-col justify-center">
            <div class="flex-shrink-0">
                <a href="/" class="text-3xl font-bold">
                    🎓 <span class="text-red-500">Direktori</span> Alumni
                </a>
            </div>
            <h2 class="mt-8 text-3xl font-bold leading-tight">Create a New Password.</h2>
            <p class="mt-4 text-gray-300">
                Choose a strong, new password to secure your account and regain access.
            </p>
        </div>

        {{-- Right Panel: Reset Password Form --}}
        <div class="p-6 sm:p-8 md:p-12">
            {{-- Mobile-only Branding --}}
            <div class="md:hidden mb-6 text-center">
                <a href="/" class="text-2xl font-bold text-gray-800 dark:text-white">
                    🎓 <span class="text-red-500">Direktori</span> Alumni
                </a>
            </div>

            <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white">Reset Your Password</h2>

            <div class="mt-6">
                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Password Reset Token -->
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="dark:text-gray-300" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="dark:text-gray-300" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                      type="password"
                                      name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Password Strength & Generator -->
                    <div class="mt-4">
                        <div class="flex items-center justify-between mb-2">
                            <span id="strength-text" class="text-xs font-semibold text-gray-500 dark:text-gray-400">PASSWORD STRENGTH</span>
                            <button type="button" id="generate-btn" class="text-xs font-semibold text-red-600 hover:text-red-500">GENERATE</button>
                        </div>
                        <div id="strength-bar" class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 flex gap-1 p-0.5">
                            <div class="strength-segment h-full rounded-full transition-all duration-300"></div>
                            <div class="strength-segment h-full rounded-full transition-all duration-300"></div>
                            <div class="strength-segment h-full rounded-full transition-all duration-300"></div>
                            <div class="strength-segment h-full rounded-full transition-all duration-300"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                            {{ __('Reset Password') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add shake animation on load
        const formCard = document.getElementById('form-card');
        setTimeout(() => {
            formCard.classList.add('animate-shake');
        }, 100);

        // Password Generator & Strength Checker
        const passwordInput = document.getElementById('password');
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const generateBtn = document.getElementById('generate-btn');
        const strengthText = document.getElementById('strength-text');
        const strengthSegments = document.querySelectorAll('.strength-segment');

        const strengthLevels = {
            0: { text: 'VERY WEAK', color: 'bg-red-500' },
            1: { text: 'WEAK', color: 'bg-orange-500' },
            2: { text: 'MEDIUM', color: 'bg-yellow-500' },
            3: { text: 'STRONG', color: 'bg-green-500' },
            4: { text: 'VERY STRONG', color: 'bg-emerald-500' },
        };

        const checkStrength = (password) => {
            let score = 0;
            if (!password) return -1;
            if (password.length >= 8) score++;
            if (password.length >= 12) score++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) score++;
            if (/[0-9]/.test(password)) score++;
            if (/[^A-Za-z0-9]/.test(password)) score++;
            return Math.max(0, score - 1);
        };

        const updateStrengthUI = (password) => {
            const score = checkStrength(password);
            strengthSegments.forEach((segment, i) => {
                segment.className = 'strength-segment h-full rounded-full transition-all duration-300'; // Reset
                if (password && i < score + 1) {
                    segment.classList.add(strengthLevels[score].color);
                }
            });

            if (password) {
                strengthText.textContent = strengthLevels[score].text;
            } else {
                strengthText.textContent = 'PASSWORD STRENGTH';
            }
        };

        const generatePassword = () => {
            const chars = {
                lower: 'abcdefghijklmnopqrstuvwxyz',
                upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
                number: '0123456789',
                symbol: '!@#$%^&*()_+~`|}{[]:;?><,./-=',
            };
            let password = '';
            password += chars.lower[Math.floor(Math.random() * chars.lower.length)];
            password += chars.upper[Math.floor(Math.random() * chars.upper.length)];
            password += chars.number[Math.floor(Math.random() * chars.number.length)];
            password += chars.symbol[Math.floor(Math.random() * chars.symbol.length)];

            const allChars = chars.lower + chars.upper + chars.number + chars.symbol;
            for (let i = 4; i < 14; i++) {
                password += allChars[Math.floor(Math.random() * allChars.length)];
            }

            // Shuffle the generated password
            return password.split('').sort(() => 0.5 - Math.random()).join('');
        };

        passwordInput.addEventListener('input', (e) => updateStrengthUI(e.target.value));

        generateBtn.addEventListener('click', () => {
            const newPassword = generatePassword();
            passwordInput.value = newPassword;
            passwordConfirmationInput.value = newPassword;
            updateStrengthUI(newPassword);
            passwordInput.dispatchEvent(new Event('input')); // Trigger update
        });

        updateStrengthUI(''); // Initial state
    });
</script>
</body>
</html>

