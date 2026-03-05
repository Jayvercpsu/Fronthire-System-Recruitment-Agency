<x-guest-layout>
    <div class="mb-4 text-sm text-slate-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4" x-data="{ showPassword: false }" data-aos="fade-up" data-aos-delay="120">
        @csrf

        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" class="floating-check" x-model="showPassword">
            <span>Show password</span>
        </label>

        <div>
            <div class="floating-group">
                <input id="password" class="floating-input" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder=" ">
                <label for="password" class="floating-label">Password</label>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
