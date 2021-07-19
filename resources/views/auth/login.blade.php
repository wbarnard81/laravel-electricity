<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img src="images/logo.png" alt="logo" style="height: 100px;">
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="remember">
                <label for="remember_me" class="form-check-label">Remember Me</label>
            </div>

            <div class="d-flex justify-content-between mt-4">
                @if (Route::has('password.request'))
                    <a class="btn btn-secondary" href="{{ route('password.request') }}">Forgot password?</a>
                @endif

                <a class="btn btn-success" href="/register">Register</a>

                <x-button class="ml-3">Log in</x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
