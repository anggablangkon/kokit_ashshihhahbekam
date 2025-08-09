<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="bg-white shadow-lg  p-4 rounded-lg">
        @csrf

        <img class="text-center rounded-lg mx-auto" src="{{ asset('internal/assets/logo.png') }}" alt="logo"
            width="100">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full bg-white" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="relative">
                <x-text-input id="password" class="block mt-1 w-full pr-10 bg-white" type="password" name="password"
                    required autocomplete="current-password" />
                <button type="button" onclick="togglePassword()" tabindex="-1"
                    style="position:absolute;top:50%;right:10px;transform:translateY(-50%);" class="text-gray-500">
                    <span id="icon-eye">
                        <!-- Eye SVG (show) -->
                        <svg id="eye-show" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        <!-- Eye Off SVG (hide), hidden by default -->
                        <svg id="eye-hide" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95m3.362-2.522A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.956 9.956 0 01-4.043 5.197M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18" />
                        </svg>
                    </span>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            {{-- @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif --}}

            <x-primary-button class="mx-auto w-full text-lg font-bold py-3 text-center flex justify-center">

                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const eyeShow = document.getElementById('eye-show');
        const eyeHide = document.getElementById('eye-hide');
        if (input.type === 'password') {
            input.type = 'text';
            eyeShow.style.display = 'none';
            eyeHide.style.display = '';
        } else {
            input.type = 'password';
            eyeShow.style.display = '';
            eyeHide.style.display = 'none';
        }
    }
</script>
