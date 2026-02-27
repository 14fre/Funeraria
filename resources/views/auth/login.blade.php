<x-guest-layout title="Iniciar sesión">
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mt-6">
                @if (Route::has('password.request'))
                    <a class="text-sm rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--color-dorado)]" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @else
                    <span></span>
                @endif
                <x-button class="auth-btn-primary sm:ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
