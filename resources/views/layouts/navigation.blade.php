<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/85 backdrop-blur">
    <div class="mx-auto flex h-16 w-full max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo/fronthire.png') }}" alt="FrontHire logo" class="h-9 w-auto">
            <span class="font-heading text-lg font-bold tracking-tight text-slate-900">FrontHire</span>
        </a>

        <div class="hidden items-center gap-6 md:flex">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-600 transition hover:text-emerald-700">Website</a>
            <a href="{{ route('dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('dashboard') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="text-sm font-semibold {{ request()->routeIs('profile.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Profile</a>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="text-sm font-semibold {{ request()->routeIs('admin.*') ? 'text-emerald-700' : 'text-slate-600 hover:text-emerald-700' }}">Admin</a>
            @endif
        </div>

        <div class="hidden items-center gap-4 md:flex">
            <div class="text-right">
                <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->full_name }}</p>
                <p class="text-xs uppercase tracking-wide text-slate-500">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                    Log out
                </button>
            </form>
        </div>

        <button @click="open = !open" type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 md:hidden">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-200 bg-white md:hidden">
        <div class="space-y-1 px-4 py-3">
            <a href="{{ route('home') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Website</a>
            <a href="{{ route('dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Dashboard</a>
            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Profile</a>
            @if (auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block rounded-xl px-3 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Admin</a>
            @endif
        </div>

        <div class="border-t border-slate-200 px-4 py-3">
            <p class="text-sm font-semibold text-slate-900">{{ auth()->user()->full_name }}</p>
            <p class="text-xs uppercase tracking-wide text-slate-500">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600">
                    Log out
                </button>
            </form>
        </div>
    </div>
</nav>
