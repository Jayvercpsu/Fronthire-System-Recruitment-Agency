<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Browse Jobs</h1>
            <p class="mt-1 text-sm text-slate-600">Search open opportunities and apply directly.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-2 lg:grid-cols-5">
            <input name="keyword" value="{{ request('keyword') }}" class="form-input lg:col-span-2" placeholder="Keyword (title/skill)">
            <input name="location" value="{{ request('location') }}" class="form-input" placeholder="Location">
            <select name="job_type" class="form-input">
                <option value="">All job types</option>
                @foreach ($jobTypes as $jobType)
                    <option value="{{ $jobType }}" @selected(request('job_type') === $jobType)>{{ str_replace('_', ' ', $jobType) }}</option>
                @endforeach
            </select>
            <select name="work_setup" class="form-input">
                <option value="">All work setups</option>
                @foreach ($workSetups as $workSetup)
                    <option value="{{ $workSetup }}" @selected(request('work_setup') === $workSetup)>{{ str_replace('_', ' ', $workSetup) }}</option>
                @endforeach
            </select>
            <div class="lg:col-span-5 flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Search</button>
                @if (request()->filled('keyword') || request()->filled('location') || request()->filled('job_type') || request()->filled('work_setup'))
                    <a href="{{ route('job-seeker.jobs.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <div class="mt-5 space-y-4">
        @forelse ($jobs as $job)
            @php
                $salaryText = 'Salary: Negotiable';
                $application = $applicationsByJob->get($job->id);
                $isViewed = $viewedJobIds->contains((int) $job->id);
                if ($job->salary_min && $job->salary_max) {
                    $salaryText = 'Salary: '.$job->currency.' '.number_format($job->salary_min).' - '.number_format($job->salary_max);
                } elseif ($job->salary_min) {
                    $salaryText = 'Salary: from '.$job->currency.' '.number_format($job->salary_min);
                } elseif ($job->salary_max) {
                    $salaryText = 'Salary: up to '.$job->currency.' '.number_format($job->salary_max);
                }
            @endphp
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <h2 class="font-heading text-xl font-bold text-slate-900">{{ $job->title }}</h2>
                        <p class="text-sm text-slate-600">{{ $job->location }}</p>
                        <p class="mt-1 text-xs text-slate-500">Employer: {{ $job->employer->employerProfile->company_name ?? $job->employer->full_name }}</p>
                        <p class="mt-2 text-sm font-semibold text-slate-800">{{ $salaryText }}</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="rounded-full bg-emerald-100 px-2 py-1 text-[11px] font-semibold uppercase text-emerald-700">{{ str_replace('_', ' ', $job->job_type) }}</span>
                            <span class="rounded-full bg-indigo-100 px-2 py-1 text-[11px] font-semibold uppercase text-indigo-700">{{ str_replace('_', ' ', $job->work_setup) }}</span>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        <a href="{{ route('job-seeker.jobs.show', $job) }}" class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">View & Apply</a>
                        @if ($application)
                            <div class="text-right">
                                <span class="inline-flex rounded-full bg-rose-100 px-2 py-1 text-[11px] font-semibold uppercase text-rose-700">
                                    Applied | {{ str_replace('_', ' ', $application->status) }}
                                </span>
                            </div>
                        @elseif ($isViewed)
                            <div class="text-right">
                                <span class="inline-flex rounded-full bg-amber-100 px-2 py-1 text-[11px] font-semibold uppercase text-amber-700">
                                    Viewed
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                <p class="mt-3 text-sm leading-relaxed text-slate-700">{{ \Illuminate\Support\Str::limit($job->description, 220) }}</p>
            </article>
        @empty
            <section class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600">
                No jobs found for your search.
            </section>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</x-app-layout>
