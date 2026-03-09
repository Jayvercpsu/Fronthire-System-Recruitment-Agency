<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">{{ $job->title }}</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $job->location }} | {{ str_replace('_', ' ', $job->job_type) }} | {{ str_replace('_', ' ', $job->work_setup) }}</p>
            </div>
            <a href="{{ route('job-seeker.jobs.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back to Jobs</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="font-heading text-lg font-bold text-slate-900">Job Description</h2>
            <p class="mt-3 whitespace-pre-line break-all text-sm leading-relaxed text-slate-700">{{ $job->description }}</p>

            @if (! empty($job->required_skills))
                <h3 class="mt-6 text-sm font-semibold uppercase tracking-wide text-slate-500">Required Skills</h3>
                <div class="mt-2 flex flex-wrap gap-2">
                    @foreach ($job->required_skills as $requiredSkill)
                        <span class="rounded-full bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">{{ $requiredSkill }}</span>
                    @endforeach
                </div>

                <div class="mt-4 rounded-xl border border-slate-200 bg-slate-50 p-3">
                    <p class="text-xs font-semibold uppercase tracking-[0.12em] text-slate-500">Your Qualification Match</p>
                    <p class="mt-2 text-sm font-semibold text-slate-900">{{ $skillMatch['match_percent'] ?? 0 }}% matched</p>

                    @if (! empty($skillMatch['matched']))
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.12em] text-emerald-700">Matched Skills</p>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach ($skillMatch['matched'] as $matchedSkill)
                                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">{{ $matchedSkill }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if (! empty($skillMatch['missing']))
                        <p class="mt-3 text-xs font-semibold uppercase tracking-[0.12em] text-amber-700">Missing Skills</p>
                        <div class="mt-1 flex flex-wrap gap-2">
                            @foreach ($skillMatch['missing'] as $missingSkill)
                                <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">{{ $missingSkill }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endif

            @if ($job->requirements)
                <h3 class="mt-6 text-sm font-semibold uppercase tracking-wide text-slate-500">Requirements</h3>
                <p class="mt-2 whitespace-pre-line break-all text-sm leading-relaxed text-slate-700">{{ $job->requirements }}</p>
            @endif
        </section>

        <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Employer</h2>
            <p class="mt-2 text-sm font-semibold text-slate-900">{{ $job->employer->employerProfile->company_name ?? $job->employer->full_name }}</p>
            <p class="text-sm text-slate-600">{{ $job->employer->email }}</p>

            @if ($job->employer->employerProfile?->about)
                <p class="mt-3 break-all text-sm leading-relaxed text-slate-700">{{ $job->employer->employerProfile->about }}</p>
            @endif

            <div class="mt-5 border-t border-slate-200 pt-4">
                @if ($existingApplication)
                    <p class="rounded-xl bg-emerald-50 px-3 py-2 text-sm font-semibold text-emerald-700">
                        You already applied to this job.
                    </p>
                    <a href="{{ route('job-seeker.applications.show', $existingApplication) }}" class="mt-3 inline-flex rounded-xl border border-emerald-300 px-4 py-2 text-sm font-semibold text-emerald-700 hover:bg-emerald-50">View Application</a>
                @else
                    <form method="POST" action="{{ route('job-seeker.jobs.apply', $job) }}" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <div>
                            <label class="form-label" for="resume_id">Select Existing Resume</label>
                            <select id="resume_id" name="resume_id" class="form-input">
                                <option value="">Select resume</option>
                                @foreach ($resumes as $resume)
                                    <option value="{{ $resume->id }}" @selected((string) old('resume_id') === (string) $resume->id)>
                                        {{ $resume->original_name }} ({{ $resume->created_at?->format('M d, Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('resume_id') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="form-label" for="resume">Or Upload New Resume (PDF/DOC/DOCX)</label>
                            <input id="resume" name="resume" type="file" accept=".pdf,.doc,.docx" class="form-input file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-emerald-700">
                            <p class="mt-1 text-xs text-slate-500">Maximum file size: 5MB</p>
                            @error('resume') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="form-label" for="cover_letter">Cover Letter (Optional)</label>
                            <textarea id="cover_letter" name="cover_letter" rows="5" class="form-input">{{ old('cover_letter') }}</textarea>
                            @error('cover_letter') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                        <button class="w-full rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Apply Now</button>
                    </form>
                @endif
            </div>
        </aside>
    </div>
</x-app-layout>
