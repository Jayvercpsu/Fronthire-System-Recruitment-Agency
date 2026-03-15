<section
    x-data="{
        showCurrentPassword: false,
        showNewPassword: false,
        showConfirmPassword: false,
        isVerifying: false,
        isVerified: {{ $errors->updatePassword->has('password') || $errors->updatePassword->has('password_confirmation') ? 'true' : 'false' }},
        verifyMessage: '',
        verifyError: '',
        async verifyCurrentPassword() {
            this.verifyMessage = '';
            this.verifyError = '';

            if (!this.$refs.currentPassword?.value) {
                this.isVerified = false;
                this.verifyError = 'Please enter your current password first.';
                return;
            }

            this.isVerifying = true;

            try {
                const response = await fetch('{{ route('password.verify-current') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')?.getAttribute('content') ?? '',
                    },
                    body: JSON.stringify({
                        current_password: this.$refs.currentPassword.value,
                    }),
                });

                const payload = await response.json().catch(() => ({}));

                if (!response.ok) {
                    this.isVerified = false;
                    this.verifyError = payload?.errors?.current_password?.[0] || payload?.message || 'Current password is incorrect.';
                    return;
                }

                this.isVerified = true;
                this.verifyMessage = payload?.message || 'Current password verified.';
            } catch (error) {
                this.isVerified = false;
                this.verifyError = 'Unable to verify current password right now. Please try again.';
            } finally {
                this.isVerifying = false;
            }
        },
    }"
>
    <header>
        <h2 class="font-heading text-xl font-bold text-slate-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Use a strong password with mixed case, numbers, and symbols.') }}
            <span class="mt-1 block text-xs text-slate-500">Step 1: verify your current password. Step 2: enter your new password.</span>
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <div class="relative">
                <div class="floating-group">
                    <input
                        id="update_password_current_password"
                        name="current_password"
                        x-ref="currentPassword"
                        x-bind:type="showCurrentPassword ? 'text' : 'password'"
                        class="floating-input pr-24"
                        autocomplete="current-password"
                        required
                        placeholder=" "
                    >
                    <label for="update_password_current_password" class="floating-label">Current Password</label>
                </div>
                <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold uppercase tracking-wide text-emerald-700 hover:text-emerald-800"
                    @click="showCurrentPassword = !showCurrentPassword"
                    x-text="showCurrentPassword ? 'Hide' : 'Show'"
                ></button>
            </div>

            <div class="mt-3 flex items-center gap-3">
                <button
                    type="button"
                    @click="verifyCurrentPassword"
                    x-bind:disabled="isVerifying"
                    class="rounded-xl border border-emerald-200 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-emerald-700 transition hover:bg-emerald-50 disabled:cursor-not-allowed disabled:opacity-60"
                >
                    <span x-show="!isVerifying">Verify Current Password</span>
                    <span x-show="isVerifying">Verifying...</span>
                </button>
                <span x-show="isVerified" class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Verified</span>
            </div>

            <p x-show="verifyMessage" x-text="verifyMessage" class="mt-2 text-sm font-medium text-emerald-700"></p>
            <p x-show="verifyError" x-text="verifyError" class="mt-2 text-sm font-medium text-rose-700"></p>
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <p x-show="!isVerified" class="text-sm text-slate-600">
            Verify your current password first to continue.
        </p>

        <div x-show="isVerified" x-cloak>
            <div class="relative">
                <div class="floating-group">
                    <input
                        id="update_password_password"
                        name="password"
                        x-bind:type="showNewPassword ? 'text' : 'password'"
                        x-bind:required="isVerified"
                        x-bind:disabled="!isVerified"
                        class="floating-input pr-20"
                        autocomplete="new-password"
                        placeholder=" "
                    >
                    <label for="update_password_password" class="floating-label">New Password</label>
                </div>
                <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold uppercase tracking-wide text-emerald-700 hover:text-emerald-800"
                    @click="showNewPassword = !showNewPassword"
                    x-text="showNewPassword ? 'Hide' : 'Show'"
                ></button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div x-show="isVerified" x-cloak>
            <div class="relative">
                <div class="floating-group">
                    <input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        x-bind:type="showConfirmPassword ? 'text' : 'password'"
                        x-bind:required="isVerified"
                        x-bind:disabled="!isVerified"
                        class="floating-input pr-20"
                        autocomplete="new-password"
                        placeholder=" "
                    >
                    <label for="update_password_password_confirmation" class="floating-label">Confirm Password</label>
                </div>
                <button
                    type="button"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-xs font-semibold uppercase tracking-wide text-emerald-700 hover:text-emerald-800"
                    @click="showConfirmPassword = !showConfirmPassword"
                    x-text="showConfirmPassword ? 'Hide' : 'Show'"
                ></button>
            </div>
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4" x-show="isVerified" x-cloak>
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
