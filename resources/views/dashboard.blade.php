<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Welcome, {{ auth()->user()->first_name }}.</h1>
            <p class="mt-1 text-sm text-slate-600">Manage your FrontHire account and access quick actions.</p>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="font-heading text-xl font-bold text-slate-900">Account Summary</h2>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <article class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Full Name</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ auth()->user()->full_name }}</p>
                </article>
                <article class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Role</p>
                    <p class="mt-1 text-lg font-semibold capitalize text-slate-900">{{ str_replace('_', ' ', auth()->user()->role) }}</p>
                </article>
                <article class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Email</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">{{ auth()->user()->email }}</p>
                </article>
                <article class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Verification</p>
                    <p class="mt-1 text-sm font-semibold {{ auth()->user()->hasVerifiedEmail() ? 'text-emerald-700' : 'text-amber-700' }}">
                        {{ auth()->user()->hasVerifiedEmail() ? 'Verified' : 'Pending verification' }}
                    </p>
                </article>
            </div>
        </section>

        <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <h2 class="font-heading text-xl font-bold text-slate-900">Quick Links</h2>
            <div class="mt-4 space-y-2">
                <a href="{{ route('profile.edit') }}" class="block rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Edit Profile</a>
                <a href="{{ route('home') }}" class="block rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">View Website</a>
                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="block rounded-xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-700 transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Open Admin Panel</a>
                @endif
            </div>
        </section>
    </div>
</x-app-layout>
