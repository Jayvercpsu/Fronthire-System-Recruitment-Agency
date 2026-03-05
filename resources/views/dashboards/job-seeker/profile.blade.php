<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Profile Builder</h1>
                <p class="mt-1 text-sm text-slate-600">Update your profile, skills, education, and experience.</p>
            </div>
            <a href="{{ route('job-seeker.jobs.index') }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Find Jobs</a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Personal Information</h2>

            <form method="POST" action="{{ route('job-seeker.profile.update') }}" class="mt-4 grid gap-4 sm:grid-cols-2">
                @csrf
                @method('PATCH')

                <div>
                    <label class="form-label" for="first_name">First Name</label>
                    <input id="first_name" name="first_name" class="form-input" value="{{ old('first_name', $user->first_name) }}" required>
                    @error('first_name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="last_name">Last Name</label>
                    <input id="last_name" name="last_name" class="form-input" value="{{ old('last_name', $user->last_name) }}" required>
                    @error('last_name') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="email">Email</label>
                    <input id="email" name="email" type="email" class="form-input" value="{{ old('email', $user->email) }}" required>
                    @error('email') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="phone">Phone</label>
                    <input id="phone" name="phone" class="form-input" value="{{ old('phone', $user->phone) }}">
                    @error('phone') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label" for="headline">Headline</label>
                    <input id="headline" name="headline" class="form-input" value="{{ old('headline', $user->headline) }}" placeholder="e.g., Warehouse Associate with 5 years experience">
                    @error('headline') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="location">Location</label>
                    <input id="location" name="location" class="form-input" value="{{ old('location', $user->location) }}">
                    @error('location') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="skills">Skills (comma separated)</label>
                    <input id="skills" name="skills" class="form-input" value="{{ old('skills', collect($user->skills ?? [])->implode(', ')) }}">
                    @error('skills') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="form-label" for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="5" class="form-input">{{ old('bio', $user->bio) }}</textarea>
                    @error('bio') <p class="form-error">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <button class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Save Profile</button>
                </div>
            </form>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Resume Upload</h2>
            <form method="POST" action="{{ route('job-seeker.resume.store') }}" enctype="multipart/form-data" class="mt-4 flex flex-wrap items-center gap-3">
                @csrf
                <input name="resume" type="file" class="form-input max-w-md file:mr-3 file:rounded-lg file:border-0 file:bg-emerald-100 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-emerald-700" accept=".pdf,.doc,.docx" required>
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Upload Resume</button>
            </form>
            <p class="mt-2 text-xs text-slate-500">Accepted: PDF, DOC, DOCX. Maximum file size: 5MB.</p>
            @error('resume') <p class="form-error mt-2">{{ $message }}</p> @enderror
            @if ($user->resumes->isNotEmpty())
                <div
                    x-data="{ open: false, previewUrl: '', downloadUrl: '', title: '', isPdf: false }"
                    @keydown.escape.window="open = false"
                >
                    <h3 class="mt-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Your Uploaded Resumes</h3>
                    <ul class="mt-2 space-y-2 text-sm text-slate-700">
                        @foreach ($user->resumes->sortByDesc('id') as $resume)
                            <li class="flex flex-wrap items-center justify-between gap-2 rounded-xl border border-slate-200 px-3 py-2">
                                <div>
                                    <p class="font-semibold text-slate-900">{{ $resume->original_name }}</p>
                                    <span class="text-xs text-slate-500">{{ $resume->created_at?->format('M d, Y h:i A') }}</span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <button
                                        type="button"
                                        class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50"
                                        @click="
                                            open = true;
                                            previewUrl = {{ \Illuminate\Support\Js::from(route('resumes.show', $resume)) }};
                                            downloadUrl = {{ \Illuminate\Support\Js::from(route('resumes.download', $resume)) }};
                                            title = {{ \Illuminate\Support\Js::from($resume->original_name) }};
                                            isPdf = {{ \Illuminate\Support\Js::from(($resume->mime_type ?? '') === 'application/pdf') }};
                                        "
                                    >
                                        View
                                    </button>
                                    <a href="{{ route('resumes.download', $resume) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                        Download
                                    </a>
                                    <form
                                        method="POST"
                                        action="{{ route('resumes.destroy', $resume) }}"
                                        data-confirm
                                        data-confirm-title="Delete resume"
                                        data-confirm-message="Delete this resume file?"
                                        data-confirm-button="Delete"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <template x-teleport="body">
                        <div
                            x-show="open"
                            style="display: none;"
                            class="fixed inset-0 z-[95] grid place-items-center p-4 sm:p-6"
                            role="dialog"
                            aria-modal="true"
                            aria-labelledby="resume-preview-title"
                            x-transition:enter="ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                        >
                            <div class="absolute inset-0 bg-slate-900/50" @click="open = false"></div>
                            <div class="relative w-full max-w-4xl rounded-2xl border border-slate-200 bg-white p-4 shadow-2xl sm:p-5" @click.stop>
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <h2 id="resume-preview-title" class="font-heading text-lg font-bold text-slate-900">Resume Preview</h2>
                                    <button type="button" @click="open = false" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Close</button>
                                </div>
                                <p class="mt-1 text-xs text-slate-500" x-text="title"></p>

                                <div class="mt-4 h-[65vh] overflow-hidden rounded-xl border border-slate-200 bg-slate-50">
                                    <template x-if="isPdf">
                                        <iframe :src="previewUrl" class="h-full w-full" title="Resume preview"></iframe>
                                    </template>
                                    <template x-if="!isPdf">
                                        <div class="flex h-full flex-col items-center justify-center gap-3 px-4 text-center">
                                            <p class="text-sm text-slate-700">Preview is available for PDF files only.</p>
                                            <a :href="downloadUrl" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Download File</a>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            @else
                <p class="mt-3 text-sm text-slate-600">No resume uploaded yet.</p>
            @endif
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Education</h2>

            <form method="POST" action="{{ route('job-seeker.education.store') }}" class="mt-4 grid gap-3 sm:grid-cols-3">
                @csrf
                <input name="school" class="form-input" placeholder="School" required>
                <input name="degree" class="form-input" placeholder="Degree" required>
                <input name="field_of_study" class="form-input" placeholder="Field of Study">
                <input name="start_date" type="date" class="form-input">
                <input name="end_date" type="date" class="form-input">
                <input name="description" class="form-input" placeholder="Description">
                <div class="sm:col-span-3">
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Add Education</button>
                </div>
            </form>

            <div class="mt-5 space-y-3">
                @forelse ($user->education as $education)
                    <div class="rounded-xl border border-slate-200 p-3">
                        <form method="POST" action="{{ route('job-seeker.education.update', $education) }}">
                            @csrf
                            @method('PATCH')
                            <div class="grid gap-2 sm:grid-cols-3">
                                <input name="school" class="form-input" value="{{ $education->school }}" required>
                                <input name="degree" class="form-input" value="{{ $education->degree }}" required>
                                <input name="field_of_study" class="form-input" value="{{ $education->field_of_study }}">
                                <input name="start_date" type="date" class="form-input" value="{{ optional($education->start_date)->format('Y-m-d') }}">
                                <input name="end_date" type="date" class="form-input" value="{{ optional($education->end_date)->format('Y-m-d') }}">
                                <input name="description" class="form-input" value="{{ $education->description }}">
                            </div>
                            <div class="mt-3">
                                <button class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Save</button>
                            </div>
                        </form>
                        <form
                            method="POST"
                            action="{{ route('job-seeker.education.destroy', $education) }}"
                            class="mt-2"
                            data-confirm
                            data-confirm-title="Delete education record"
                            data-confirm-message="Delete this education record?"
                            data-confirm-button="Delete"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-600">No education records yet.</p>
                @endforelse
            </div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Experience</h2>

            <form method="POST" action="{{ route('job-seeker.experiences.store') }}" class="mt-4 grid gap-3 sm:grid-cols-3">
                @csrf
                <input name="company" class="form-input" placeholder="Company" required>
                <input name="position" class="form-input" placeholder="Position" required>
                <input name="employment_type" class="form-input" placeholder="Employment Type">
                <input name="location" class="form-input" placeholder="Location">
                <input name="start_date" type="date" class="form-input">
                <input name="end_date" type="date" class="form-input">
                <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                    <input type="checkbox" name="is_current" value="1" class="floating-check">
                    Currently working here
                </label>
                <input name="description" class="form-input sm:col-span-2" placeholder="Description">
                <div class="sm:col-span-3">
                    <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Add Experience</button>
                </div>
            </form>

            <div class="mt-5 space-y-3">
                @forelse ($user->experiences as $experience)
                    <div class="rounded-xl border border-slate-200 p-3">
                        <form method="POST" action="{{ route('job-seeker.experiences.update', $experience) }}">
                            @csrf
                            @method('PATCH')
                            <div class="grid gap-2 sm:grid-cols-3">
                                <input name="company" class="form-input" value="{{ $experience->company }}" required>
                                <input name="position" class="form-input" value="{{ $experience->position }}" required>
                                <input name="employment_type" class="form-input" value="{{ $experience->employment_type }}">
                                <input name="location" class="form-input" value="{{ $experience->location }}">
                                <input name="start_date" type="date" class="form-input" value="{{ optional($experience->start_date)->format('Y-m-d') }}">
                                <input name="end_date" type="date" class="form-input" value="{{ optional($experience->end_date)->format('Y-m-d') }}">
                                <label class="inline-flex items-center gap-2 text-sm font-medium text-slate-700">
                                    <input type="checkbox" name="is_current" value="1" class="floating-check" @checked($experience->is_current)>
                                    Current
                                </label>
                                <input name="description" class="form-input sm:col-span-2" value="{{ $experience->description }}">
                            </div>
                            <div class="mt-3">
                                <button class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Save</button>
                            </div>
                        </form>
                        <form
                            method="POST"
                            action="{{ route('job-seeker.experiences.destroy', $experience) }}"
                            class="mt-2"
                            data-confirm
                            data-confirm-title="Delete experience record"
                            data-confirm-message="Delete this experience record?"
                            data-confirm-button="Delete"
                        >
                            @csrf
                            @method('DELETE')
                            <button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-600">No experience records yet.</p>
                @endforelse
            </div>
        </section>
    </div>
</x-app-layout>
