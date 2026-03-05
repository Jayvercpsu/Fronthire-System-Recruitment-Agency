<section x-data="{ showPasswords: false }">
    <header>
        <h2 class="font-heading text-xl font-bold text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Use a strong password with mixed case, numbers, and symbols.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <label class="inline-flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" class="floating-check" x-model="showPasswords">
            <span>Show password fields</span>
        </label>

        <div>
            <div class="floating-group">
                <input id="update_password_current_password" name="current_password" x-bind:type="showPasswords ? 'text' : 'password'" class="floating-input" autocomplete="current-password" placeholder=" ">
                <label for="update_password_current_password" class="floating-label">Current Password</label>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <div class="floating-group">
                <input id="update_password_password" name="password" x-bind:type="showPasswords ? 'text' : 'password'" class="floating-input" autocomplete="new-password" placeholder=" ">
                <label for="update_password_password" class="floating-label">New Password</label>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <div class="floating-group">
                <input id="update_password_password_confirmation" name="password_confirmation" x-bind:type="showPasswords ? 'text' : 'password'" class="floating-input" autocomplete="new-password" placeholder=" ">
                <label for="update_password_password_confirmation" class="floating-label">Confirm Password</label>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
