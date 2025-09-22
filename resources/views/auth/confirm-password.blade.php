<x-guest-layout>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col items-center justify-center p-4">

        <!-- Laracon Style Icon -->
        <div class="mb-8">
            <a href="/">
                <svg class="h-12 w-12 text-gray-400 dark:text-gray-600 transition-colors duration-300 hover:text-red-500" fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M24.7,3.12,5.2,13.34V33.78l19.5,10.22,19.5-10.22V13.34Zm0,3.87,15.6,8.18-7.8,4.09-15.6-8.18Zm-15.6,10,7.8,4.09-7.8,4.09Zm19.5,18.4-15.6-8.18,7.8-4.09,15.6,8.18Zm7.8-14.31-7.8-4.09,7.8-4.09V25.2Z"/>
                </svg>
            </a>
        </div>

        <div class="max-w-4xl w-full mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-2xl overflow-hidden grid md:grid-cols-2">

            {{-- Left Panel: Branding & Message --}}
            <div class="p-8 md:p-12 bg-gray-800 text-white hidden md:flex flex-col justify-center">
                <div class="flex-shrink-0">
                    <a href="/" class="text-3xl font-bold">
                        🎓 <span class="text-red-500">Direktori</span> Alumni
                    </a>
                </div>
                <h2 class="mt-8 text-3xl font-bold leading-tight">Security Check</h2>
                <p class="mt-4 text-gray-300">
                    This is a secure area of the application. Please confirm your password to continue.
                </p>
            </div>

            {{-- Right Panel: Confirm Password Form --}}
            <div class="p-8 md:p-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Confirm Your Password</h2>
                <div class="mt-6">
                    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('Please confirm your password before continuing.') }}
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="dark:text-gray-300" />
                            <x-text-input id="password" class="block mt-1 w-full"
                                          type="password"
                                          name="password"
                                          required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="flex justify-end mt-6">
                            <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 bg-red-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

