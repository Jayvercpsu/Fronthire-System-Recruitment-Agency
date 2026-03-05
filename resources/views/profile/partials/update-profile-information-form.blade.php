<section>
    <header>
        <h2 class="font-heading text-xl font-bold text-slate-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-slate-600">
            {{ __('Update your personal details and email address.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <div class="floating-group">
                    <input id="first_name" name="first_name" type="text" class="floating-input" value="{{ old('first_name', $user->first_name) }}" required autofocus autocomplete="given-name" placeholder=" ">
                    <label for="first_name" class="floating-label">First Name</label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>
            <div>
                <div class="floating-group">
                    <input id="last_name" name="last_name" type="text" class="floating-input" value="{{ old('last_name', $user->last_name) }}" required autocomplete="family-name" placeholder=" ">
                    <label for="last_name" class="floating-label">Last Name</label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <div class="floating-group">
                    <input id="email" name="email" type="email" class="floating-input" value="{{ old('email', $user->email) }}" required autocomplete="username" placeholder=" ">
                    <label for="email" class="floating-label">Email</label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('email')" />
            </div>
            <div>
                <div class="floating-group">
                    <input id="phone" name="phone" type="text" class="floating-input" value="{{ old('phone', $user->phone) }}" autocomplete="tel" placeholder=" ">
                    <label for="phone" class="floating-label">Phone</label>
                </div>
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>
        </div>

        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div>
                <p class="text-sm text-amber-700">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="font-semibold text-emerald-700 underline hover:text-emerald-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 text-sm font-medium text-emerald-700">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif

                @if ($errors->has('email_verification'))
                    <p class="mt-2 text-sm font-medium text-rose-700">
                        {{ $errors->first('email_verification') }}
                    </p>
                @endif
            </div>
        @endif

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
