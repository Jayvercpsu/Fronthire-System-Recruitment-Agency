<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4" data-aos="fade-up" data-aos-delay="120">
        @csrf

        <div>
            <div class="floating-group">
                <input id="email" class="floating-input" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder=" ">
                <label for="email" class="floating-label">Email</label>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
