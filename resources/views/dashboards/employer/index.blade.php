<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Employer Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">Manage job postings, applicants, and recruiter conversations.</p>
        </div>
    </x-slot>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-6">
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Active Jobs</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['active_jobs'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Total Applicants</p>
            <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total_applicants'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Shortlisted</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $stats['shortlisted'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Interviews</p>
            <p class="mt-2 text-2xl font-bold text-indigo-700">{{ $stats['interviews'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Hired</p>
            <p class="mt-2 text-2xl font-bold text-emerald-700">{{ $stats['hired'] }}</p>
        </article>
        <article class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <p class="text-xs uppercase tracking-[0.14em] text-slate-500">Unread Chats</p>
            <p class="mt-2 text-2xl font-bold text-amber-700">{{ $stats['unread_messages'] }}</p>
        </article>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="font-heading text-lg font-bold text-slate-900">Recent Jobs</h2>
                <a href="{{ route('employer.jobs.create') }}" class="rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold uppercase tracking-wide text-white hover:bg-emerald-700">Post Job</a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($recentJobs as $job)
                    <article class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                                <p class="text-xs text-slate-500">{{ $job->location }} | {{ str_replace('_', ' ', $job->job_type) }}</p>
                            </div>
                            <span class="rounded-full px-2 py-1 text-[11px] font-semibold uppercase {{ $job->status === 'published' ? 'bg-emerald-100 text-emerald-700' : ($job->status === 'closed' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ str_replace('_', ' ', $job->status) }}
                            </span>
                        </div>
                        <div class="mt-3 flex items-center justify-between text-xs text-slate-600">
                            <span>{{ $job->applications_count }} applicants</span>
                            <a href="{{ route('employer.jobs.applicants.index', $job) }}" class="font-semibold text-emerald-700 hover:underline">View Applicants</a>
                        </div>
                    </article>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-300 p-4 text-sm text-slate-600">No jobs posted yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="font-heading text-lg font-bold text-slate-900">Latest Applicants</h2>
                <a href="{{ route('employer.jobs.index') }}" class="text-xs font-semibold uppercase tracking-wide text-emerald-700 hover:underline">All Jobs</a>
            </div>

            <div class="mt-4 space-y-3">
                @forelse ($recentApplicants as $application)
                    <article class="rounded-xl border border-slate-200 p-3">
                        <p class="font-semibold text-slate-900">{{ $application->jobSeeker->full_name }}</p>
                        <p class="text-xs text-slate-500">{{ $application->jobSeeker->email }}</p>
                        <p class="mt-2 text-xs text-slate-600">Applied for: <span class="font-semibold">{{ $application->job->title }}</span></p>
                        <div class="mt-3 flex items-center justify-between">
                            <span class="rounded-full bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase text-slate-700">{{ str_replace('_', ' ', $application->status) }}</span>
                            <a href="{{ route('employer.jobs.applicants.index', $application->job_id) }}" class="text-xs font-semibold text-emerald-700 hover:underline">Open Job Applicants</a>
                        </div>
                    </article>
                @empty
                    <p class="rounded-xl border border-dashed border-slate-300 p-4 text-sm text-slate-600">No applicants yet.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>

