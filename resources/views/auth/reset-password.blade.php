<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-4" x-data="{ showPassword: false }" data-aos="fade-up" data-aos-delay="120">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <div class="floating-group">
                <input id="email" class="floating-input" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" placeholder=" ">
                <label for="email" class="floating-label">Email</label>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" class="floating-check" x-model="showPassword">
            <span>Show password fields</span>
        </label>

        <div>
            <div class="floating-group">
                <input id="password" class="floating-input" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder=" ">
                <label for="password" class="floating-label">New Password</label>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <div class="floating-group">
                <input id="password_confirmation" class="floating-input" x-bind:type="showPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder=" ">
                <label for="password_confirmation" class="floating-label">Confirm Password</label>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
