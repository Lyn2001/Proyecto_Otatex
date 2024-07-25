
<x-guest-layout>
    <div class="flex justify-center mb-4">
        <img src="{{ asset('images/Logotipo-Otatex.png') }}" alt="Logotipo-Otatex" class="w-18 h-18 object-contain">
    </div>

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" />

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="mt-4 space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Forgot Password Link -->
        @if (Route::has('password.request'))
        <div class="text-right">
            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{ __('Forgot your password?') }}</a>
        </div>
        @endif

        <!-- Recaptcha -->
        <div>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
            {!! htmlFormSnippet() !!}
            @if ($errors->has('g-recaptcha-response'))
            <div>
                <small style="color: red;">{{ $errors->first('g-recaptcha-response') }}</small>
            </div>
            @endif
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>