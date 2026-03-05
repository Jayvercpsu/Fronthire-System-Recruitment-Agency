<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Applicants: {{ $job->title }}</h1>
                <p class="mt-1 text-sm text-slate-600">Review candidate profiles, update status, and add internal notes.</p>
            </div>
            <a href="{{ route('employer.jobs.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back to Jobs</a>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-3">
            <input type="text" name="search" class="form-input" value="{{ request('search') }}" placeholder="Search applicant name/email">
            <select name="status" class="form-input">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                @endforeach
            </select>
            <div class="flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Filter</button>
                @if (request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('employer.jobs.applicants.index', $job) }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <div class="mt-5 space-y-4">
        @forelse ($applications as $application)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-heading text-lg font-bold text-slate-900">{{ $application->jobSeeker->full_name }}</h2>
                        <p class="text-sm text-slate-600">{{ $application->jobSeeker->email }} @if($application->jobSeeker->location)| {{ $application->jobSeeker->location }} @endif</p>
                        @if ($application->jobSeeker->headline)
                            <p class="mt-1 text-sm font-medium text-slate-700">{{ $application->jobSeeker->headline }}</p>
                        @endif
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <span class="rounded-full bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase text-slate-700">{{ str_replace('_', ' ', $application->status) }}</span>
                        @if ($application->conversation)
                            <a href="{{ route('chat.show', $application->conversation) }}" class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Message</a>
                        @endif
                    </div>
                </div>

                @if ($application->jobSeeker->bio)
                    <p class="mt-3 text-sm leading-relaxed text-slate-700">{{ $application->jobSeeker->bio }}</p>
                @endif

                @if (! empty($application->jobSeeker->skills))
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($application->jobSeeker->skills as $skill)
                            <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $skill }}</span>
                        @endforeach
                    </div>
                @endif

                @php($qualification = $application->skill_qualification ?? null)
                @if ($qualification && $qualification['required_count'] > 0)
                    <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                        <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Skills Qualification</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">{{ $qualification['match_percent'] ?? 0 }}% match</p>

                        @if (! empty($qualification['matched']))
                            <p class="mt-2 text-xs font-semibold uppercase tracking-[0.12em] text-emerald-700">Matched</p>
                            <div class="mt-1 flex flex-wrap gap-2">
                                @foreach ($qualification['matched'] as $matchedSkill)
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $matchedSkill }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if (! empty($qualification['missing']))
                            <p class="mt-3 text-xs font-semibold uppercase tracking-[0.12em] text-amber-700">Missing</p>
                            <div class="mt-1 flex flex-wrap gap-2">
                                @foreach ($qualification['missing'] as $missingSkill)
                                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">{{ $missingSkill }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mt-4 grid gap-4 md:grid-cols-2">
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Education</h3>
                        <ul class="mt-2 space-y-2 text-sm text-slate-700">
                            @forelse ($application->jobSeeker->education as $education)
                                <li class="rounded-lg border border-slate-200 p-2">
                                    <p class="font-semibold">{{ $education->degree }} @if($education->field_of_study)- {{ $education->field_of_study }} @endif</p>
                                    <p class="text-xs text-slate-500">{{ $education->school }}</p>
                                </li>
                            @empty
                                <li class="text-xs text-slate-500">No education entries.</li>
                            @endforelse
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Experience</h3>
                        <ul class="mt-2 space-y-2 text-sm text-slate-700">
                            @forelse ($application->jobSeeker->experiences as $experience)
                                <li class="rounded-lg border border-slate-200 p-2">
                                    <p class="font-semibold">{{ $experience->position }} @ {{ $experience->company }}</p>
                                    <p class="text-xs text-slate-500">{{ $experience->employment_type ?? 'N/A' }}</p>
                                </li>
                            @empty
                                <li class="text-xs text-slate-500">No experience entries.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="mt-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Resume</h3>
                    @php($submittedResume = $application->resume)
                    @php($latestResume = $application->jobSeeker->resumes->sortByDesc('id')->first())
                    @if ($submittedResume)
                        <a href="{{ $submittedResume->url }}" target="_blank" rel="noopener" class="mt-2 inline-flex rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">
                            Submitted Resume: {{ $submittedResume->original_name }}
                        </a>
                    @elseif ($latestResume)
                        <a href="{{ $latestResume->url }}" target="_blank" rel="noopener" class="mt-2 inline-flex rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                            Latest Resume: {{ $latestResume->original_name }}
                        </a>
                    @else
                        <p class="mt-2 text-xs text-slate-500">No resume uploaded.</p>
                    @endif
                </div>

                <form method="POST" action="{{ route('employer.jobs.applications.update', [$job, $application]) }}" class="mt-5 grid gap-3 md:grid-cols-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="form-label" for="status-{{ $application->id }}">Status</label>
                        <select id="status-{{ $application->id }}" name="status" class="form-input">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($application->status === $status)>{{ str_replace('_', ' ', $status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label" for="internal-notes-{{ $application->id }}">Internal Notes</label>
                        <input id="internal-notes-{{ $application->id }}" name="internal_notes" class="form-input" value="{{ $application->internal_notes }}">
                    </div>
                    <div class="md:col-span-3">
                        <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Update Application</button>
                    </div>
                </form>
            </article>
        @empty
            <section class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600">
                No applicants found for this job.
            </section>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</x-app-layout>
