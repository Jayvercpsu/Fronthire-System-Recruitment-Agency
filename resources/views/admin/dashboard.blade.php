<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Admin Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">Overview of FrontHire platform activity.</p>
        </div>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Users</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['users_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Employers</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['employers_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Job Seekers</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['job_seekers_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Inquiries</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['inquiries_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Contacts</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['contacts_total'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Resumes</p>
            <p class="mt-1 text-2xl font-bold text-slate-900">{{ $stats['resumes_total'] }}</p>
        </article>
    </div>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="{{ route('admin.inquiries.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Manage Inquiries</a>
        <a href="{{ route('admin.contacts.index') }}" class="rounded-2xl border border-slate-200 bg-white px-5 py-4 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Manage Contacts</a>
    </div>
</x-app-layout>
