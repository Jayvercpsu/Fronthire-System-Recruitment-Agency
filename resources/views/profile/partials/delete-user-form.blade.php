<section class="space-y-6" x-data="{ showDeletePassword: false }">
    <header>
        <h2 class="font-heading text-xl font-bold text-slate-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Deleting your account is permanent and cannot be undone.') }}
        </p>
    </header>

    @if (auth()->user()->role === 'admin')
        <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
            Admin account cannot delete itself from the profile panel.
        </div>
    @else
        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        >{{ __('Delete Account') }}</x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <h2 class="font-heading text-xl font-bold text-slate-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-2 text-sm text-slate-600">
                    {{ __('Please confirm by entering your password.') }}
                </p>

                <label class="mt-4 inline-flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" class="floating-check" x-model="showDeletePassword">
                    <span>Show password</span>
                </label>

                <div class="mt-4">
                    <div class="floating-group">
                        <input id="password" name="password" x-bind:type="showDeletePassword ? 'text' : 'password'" class="floating-input" placeholder=" ">
                        <label for="password" class="floating-label">Password</label>
                    </div>

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    @endif
</section>
