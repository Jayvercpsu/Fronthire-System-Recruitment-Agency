<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Job Seeker Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">Track your applications and keep your profile job-ready.</p>
        </div>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Applications Sent</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['applications_sent'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Under Review</p>
            <p class="mt-2 text-2xl font-bold text-amber-700">{{ $stats['under_review'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Interviews</p>
            <p class="mt-2 text-2xl font-bold text-indigo-700">{{ $stats['interviews'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Offers</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $stats['offers'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Hired</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $stats['hired'] }}</p>
        </article>
    </div>

    <section class="mt-6 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="font-heading text-lg font-bold text-slate-900">Recent Applications</h2>
            <div class="flex gap-2">
                <a href="{{ route('job-seeker.jobs.index') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-white hover:bg-emerald-700">Browse Jobs</a>
                <a href="{{ route('job-seeker.profile.edit') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-slate-700 hover:bg-slate-50">Profile Builder</a>
            </div>
        </div>

        <div class="mt-4 space-y-3">
            @forelse ($recentApplications as $application)
                <article class="rounded-xl border border-slate-200 p-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <p class="font-semibold text-slate-900">{{ $application->job->title }}</p>
                            <p class="text-xs text-slate-500">{{ $application->job->location }} | {{ str_replace('_', ' ', $application->job->work_setup) }}</p>
                        </div>
                        <span class="rounded-full bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase text-slate-700">{{ str_replace('_', ' ', $application->status) }}</span>
                    </div>
                    <div class="mt-3 flex items-center justify-between text-xs">
                        <span class="text-slate-500">Employer: {{ $application->job->employer->full_name }}</span>
                        <a href="{{ route('job-seeker.applications.show', $application) }}" class="font-semibold text-emerald-700 hover:underline">View Timeline</a>
                    </div>
                </article>
            @empty
                <p class="rounded-xl border border-dashed border-slate-300 p-4 text-sm text-slate-600">No applications yet.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>

