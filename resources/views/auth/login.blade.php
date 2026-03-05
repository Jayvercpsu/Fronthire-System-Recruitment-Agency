<x-guest-layout>
    <div class="mb-6 text-center">
        <img src="{{ asset('images/logo/fronthire.png') }}" alt="FrontHire logo" class="mx-auto mb-3 h-20 w-auto" data-aos="zoom-in" data-aos-delay="60">
        <h1 class="font-heading text-3xl font-bold text-slate-900">Sign In</h1>
        <p class="mt-1 text-sm font-medium text-slate-700">Access your FrontHire dashboard.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }" class="space-y-4" data-aos="fade-up" data-aos-delay="120">
        @csrf

        <div>
            <div class="floating-group">
                <input id="email" class="floating-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder=" ">
                <label for="email" class="floating-label">Email</label>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="floating-group">
                <input id="password" class="floating-input" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder=" ">
                <label for="password" class="floating-label">Password</label>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-1 flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                <input id="remember_me" type="checkbox" class="floating-check" name="remember">
                <span>{{ __('Remember me') }}</span>
            </label>

            <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                <input type="checkbox" class="floating-check" x-model="showPassword">
                <span>Show password</span>
            </label>
        </div>

        <div class="mt-4 flex items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="rounded-lg border border-emerald-200 bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-100">Home</a>

            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="mt-3 space-y-1 text-center">
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-slate-700 underline hover:text-emerald-800" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <p class="text-sm font-medium text-slate-700">
                Don't have an account yet?
                <a href="{{ route('register', ['role' => 'job_seeker']) }}" class="underline hover:text-emerald-800">
                    Sign up
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
