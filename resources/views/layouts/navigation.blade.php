<nav x-data="{ open: false, showLogoutModal: false }" @keydown.escape.window="showLogoutModal = false" class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur">
    @php($unreadNotificationsCount = auth()->user()->unreadNotifications()->count())

    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo/fronthire.png') }}" alt="FrontHire logo" class="h-9 w-auto">
            <span class="font-heading text-lg font-bold tracking-tight text-slate-900">FrontHire</span>
        </a>

        <div class="hidden items-center gap-6 md:flex">
            @if (auth()->user()->role === 'employer')
                <a href="{{ route('employer.dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('employer.dashboard') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Overview</a>
                <a href="{{ route('employer.jobs.index') }}" class="text-sm font-semibold {{ request()->routeIs('employer.jobs.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Jobs</a>
                <a href="{{ route('employer.company-profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('employer.company-profile.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Company</a>
                <a href="{{ route('chat.index') }}" class="text-sm font-semibold {{ request()->routeIs('chat.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Messages</a>
                <a href="{{ route('profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('profile.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Account</a>
            @elseif (auth()->user()->role === 'job_seeker')
                <a href="{{ route('job-seeker.dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('job-seeker.dashboard') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Overview</a>
                <a href="{{ route('job-seeker.jobs.index') }}" class="text-sm font-semibold {{ request()->routeIs('job-seeker.jobs.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Browse Jobs</a>
                <a href="{{ route('job-seeker.applications.index') }}" class="text-sm font-semibold {{ request()->routeIs('job-seeker.applications.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Applications</a>
                <a href="{{ route('job-seeker.profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('job-seeker.profile.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Profile Builder</a>
                <a href="{{ route('chat.index') }}" class="text-sm font-semibold {{ request()->routeIs('chat.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Messages</a>
                <a href="{{ route('profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('profile.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Account</a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Overview</a>
                <a href="{{ route('admin.users.index') }}" class="text-sm font-semibold {{ request()->routeIs('admin.users.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Users</a>
                <a href="{{ route('admin.jobs.index') }}" class="text-sm font-semibold {{ request()->routeIs('admin.jobs.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Jobs</a>
                <a href="{{ route('admin.applications.index') }}" class="text-sm font-semibold {{ request()->routeIs('admin.applications.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Applications</a>
                <a href="{{ route('profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('profile.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Account</a>
            @endif
        </div>

        <div class="hidden items-center gap-4 md:flex">
            <a href="{{ route('notifications.index') }}" class="relative inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700" title="Notifications" aria-label="Notifications">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.4-1.4a2 2 0 0 1-.6-1.4V11a6 6 0 1 0-12 0v3.2a2 2 0 0 1-.6 1.4L4 17h5m6 0a3 3 0 1 1-6 0m6 0H9" />
                </svg>
                @if ($unreadNotificationsCount > 0)
                    <span class="absolute -right-1.5 -top-1.5 inline-flex min-h-5 min-w-5 items-center justify-center rounded-full bg-rose-600 px-1.5 text-[10px] font-bold leading-none text-white">
                        {{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}
                    </span>
                @endif
            </a>
            <a href="{{ route('profile.edit') }}" class="text-right">
                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->full_name }}</p>
                <p class="text-xs uppercase tracking-wide text-slate-500">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
            </a>
            <button type="button" @click="showLogoutModal = true" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                Log out
            </button>
        </div>

        <button @click="open = !open" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 md:hidden">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-200 bg-white md:hidden">
        <div class="space-y-1 px-4 py-3">
            @if (auth()->user()->role === 'employer')
                <a href="{{ route('employer.dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Overview</a>
                <a href="{{ route('employer.jobs.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Jobs</a>
                <a href="{{ route('employer.company-profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Company</a>
                <a href="{{ route('chat.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Messages</a>
                <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Account</a>
            @elseif (auth()->user()->role === 'job_seeker')
                <a href="{{ route('job-seeker.dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Overview</a>
                <a href="{{ route('job-seeker.jobs.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Browse Jobs</a>
                <a href="{{ route('job-seeker.applications.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Applications</a>
                <a href="{{ route('job-seeker.profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Profile Builder</a>
                <a href="{{ route('chat.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Messages</a>
                <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Account</a>
            @else
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Overview</a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Users</a>
                <a href="{{ route('admin.jobs.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Jobs</a>
                <a href="{{ route('admin.applications.index') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Applications</a>
                <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Account</a>
            @endif

            <a href="{{ route('notifications.index') }}" class="flex items-center justify-between rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">
                <span>Notifications</span>
                @if ($unreadNotificationsCount > 0)
                    <span class="rounded-full bg-rose-600 px-2 py-0.5 text-[10px] font-bold text-white">{{ $unreadNotificationsCount > 99 ? '99+' : $unreadNotificationsCount }}</span>
                @endif
            </a>
        </div>

        <div class="border-t border-slate-200 px-4 py-3">
            <a href="{{ route('profile.edit') }}" class="block text-sm font-semibold text-slate-900">{{ auth()->user()->full_name }}</a>
            <p class="text-xs uppercase tracking-wide text-slate-500">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
            <button type="button" @click="showLogoutModal = true; open = false" class="mt-3 w-full rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                Log out
            </button>
        </div>
    </div>

    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
        @csrf
    </form>

    <template x-teleport="body">
        <div
            x-show="showLogoutModal"
            style="display: none;"
            class="fixed inset-0 z-[90] grid place-items-center p-4 sm:p-6"
            role="dialog"
            aria-modal="true"
            aria-labelledby="logout-confirm-title"
            x-transition:enter="ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
        >
            <div class="absolute inset-0 bg-slate-900/50" @click="showLogoutModal = false"></div>
            <div
                class="relative w-full max-w-md rounded-2xl border border-slate-200 bg-white p-5 shadow-2xl sm:p-6"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-2 scale-[0.98]"
                x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                x-transition:leave-end="opacity-0 translate-y-2 scale-[0.98]"
                @click.stop
            >
                <h2 id="logout-confirm-title" class="font-heading text-xl font-bold text-slate-900">Confirm logout</h2>
                <p class="mt-2 text-sm text-slate-600">Are you sure you want to log out from your dashboard?</p>
                <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end sm:gap-3">
                    <button type="button" @click="showLogoutModal = false" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancel</button>
                    <button type="button" @click="showLogoutModal = false; document.getElementById('logout-form').submit();" class="rounded-xl bg-rose-600 px-4 py-2 text-sm font-semibold text-white hover:bg-rose-700">Log out</button>
                </div>
            </div>
        </div>
    </template>
</nav>
