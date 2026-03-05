<x-guest-layout>
    <div
        x-data="{
            selectedRole: '{{ $role }}',
            showPassword: false,
            switching: false,
            switchRole(role) {
                if (this.selectedRole === role) return;
                this.switching = true;
                setTimeout(() => {
                    this.selectedRole = role;
                    this.switching = false;
                    const url = new URL(window.location.href);
                    url.searchParams.set('role', role);
                    window.history.replaceState({}, '', url.toString());
                }, 140);
            }
        }"
    >
    <div class="mb-6 text-center transition-all duration-300 ease-out" :class="switching ? 'translate-x-5 opacity-0' : 'translate-x-0 opacity-100'">
        <h1 class="font-heading text-3xl font-bold text-slate-900">Create Account</h1>
        <p class="mt-1 text-sm font-medium text-slate-700">
            Registering as
            <span class="font-semibold text-emerald-800" x-text="selectedRole === 'employer' ? 'Employer' : 'Job Seeker'"></span>.
        </p>
    </div>

    <div class="mb-5 rounded-2xl border border-emerald-200 bg-white/85 p-2">
        <p class="px-2 pb-2 text-xs font-semibold uppercase tracking-[0.15em] text-slate-600">Register As</p>
        <div class="flex items-center gap-2">
            <button
                type="button"
                @click="switchRole('job_seeker')"
                :class="selectedRole === 'job_seeker'
                    ? 'bg-emerald-600 text-white shadow-sm'
                    : 'bg-white text-slate-700 hover:bg-emerald-50'"
                class="flex-1 rounded-xl px-3 py-2 text-sm font-semibold transition"
            >
                Job Seeker
            </button>
            <button
                type="button"
                @click="switchRole('employer')"
                :class="selectedRole === 'employer'
                    ? 'bg-emerald-600 text-white shadow-sm'
                    : 'bg-white text-slate-700 hover:bg-emerald-50'"
                class="flex-1 rounded-xl px-3 py-2 text-sm font-semibold transition"
            >
                Employer
            </button>
        </div>
    </div>

    <form method="POST" x-bind:action="`{{ route('register') }}?role=${selectedRole}`" class="space-y-4 transition-all duration-300 ease-out" :class="switching ? 'translate-x-5 opacity-0' : 'translate-x-0 opacity-100'" data-aos="fade-up" data-aos-delay="120">
        @csrf

        <input type="hidden" name="role" x-model="selectedRole">

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <div class="floating-group">
                    <input id="first_name" class="floating-input" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus autocomplete="given-name" placeholder=" ">
                    <label for="first_name" class="floating-label">First Name</label>
                </div>
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div>
                <div class="floating-group">
                    <input id="last_name" class="floating-input" type="text" name="last_name" value="{{ old('last_name') }}" required autocomplete="family-name" placeholder=" ">
                    <label for="last_name" class="floating-label">Last Name</label>
                </div>
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>
        </div>

        <div>
            <div class="floating-group">
                <input id="email" class="floating-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder=" ">
                <label for="email" class="floating-label">Email</label>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
            <input type="checkbox" class="floating-check" x-model="showPassword">
            <span>Show password fields</span>
        </label>

        <div>
            <div class="floating-group">
                <input id="password" class="floating-input" x-bind:type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password" placeholder=" ">
                <label for="password" class="floating-label">Password</label>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
            <p class="mt-1 text-xs font-medium text-slate-700/80">Minimum 10 characters with uppercase, lowercase, number, and symbol.</p>
        </div>

        <div>
            <div class="floating-group">
                <input id="password_confirmation" class="floating-input" x-bind:type="showPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password" placeholder=" ">
                <label for="password_confirmation" class="floating-label">Confirm Password</label>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between pt-2">
            <a class="text-sm font-medium text-slate-700 underline hover:text-emerald-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    </div>
</x-guest-layout>
