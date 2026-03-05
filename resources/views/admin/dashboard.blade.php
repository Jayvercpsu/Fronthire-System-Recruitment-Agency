<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Admin Dashboard</h1>
                <p class="mt-1 text-sm text-slate-600">Platform-wide recruitment operations and moderation.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.export.users') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 hover:bg-slate-50">CSV Users</a>
                <a href="{{ route('admin.export.jobs') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 hover:bg-slate-50">CSV Jobs</a>
                <a href="{{ route('admin.export.applications') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 hover:bg-slate-50">CSV Applications</a>
            </div>
        </div>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Employers</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['employers_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Job Seekers</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['job_seekers_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Jobs</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['jobs_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Applications</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['applications_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Active Jobs</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $stats['active_jobs'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Hired</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $stats['hired_total'] }}</p>
        </article>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <a href="{{ route('admin.users.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Manage Users</a>
        <a href="{{ route('admin.jobs.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Manage Jobs</a>
        <a href="{{ route('admin.applications.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Manage Applications</a>
    </div>
</x-app-layout>

