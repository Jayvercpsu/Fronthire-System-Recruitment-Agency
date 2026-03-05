<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">User Details</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $user->full_name }} | {{ str_replace('_', ' ', $user->role) }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-1">
            <h2 class="font-heading text-lg font-bold text-slate-900">Profile</h2>
            <dl class="mt-3 space-y-2 text-sm text-slate-700">
                <div><dt class="font-semibold">Email</dt><dd>{{ $user->email }}</dd></div>
                <div><dt class="font-semibold">Phone</dt><dd>{{ $user->phone ?: 'N/A' }}</dd></div>
                <div><dt class="font-semibold">Location</dt><dd>{{ $user->location ?: 'N/A' }}</dd></div>
                <div><dt class="font-semibold">Status</dt><dd>{{ $user->is_active ? 'Active' : 'Inactive' }}</dd></div>
                @if ($user->isEmployer())
                    <div><dt class="font-semibold">Company Name</dt><dd>{{ $user->employerProfile?->company_name ?: 'N/A' }}</dd></div>
                    <div><dt class="font-semibold">Industry</dt><dd>{{ $user->employerProfile?->industry ?: 'N/A' }}</dd></div>
                    <div><dt class="font-semibold">Website</dt><dd>{{ $user->employerProfile?->website ?: 'N/A' }}</dd></div>
                @endif
            </dl>

            @if ($user->headline)
                <h3 class="mt-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Headline</h3>
                <p class="mt-1 text-sm text-slate-700">{{ $user->headline }}</p>
            @endif

            @if ($user->bio)
                <h3 class="mt-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Bio</h3>
                <p class="mt-1 text-sm text-slate-700">{{ $user->bio }}</p>
            @endif
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            @if ($user->isEmployer())
                <h2 class="font-heading text-lg font-bold text-slate-900">Posted Jobs</h2>
                <div class="mt-3 space-y-2">
                    @forelse ($jobs as $job)
                        <article class="rounded-xl border border-slate-200 p-3">
                            <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                            <p class="text-xs text-slate-500">{{ $job->location }} | {{ $job->applications_count }} applicants</p>
                        </article>
                    @empty
                        <p class="text-sm text-slate-600">No jobs posted.</p>
                    @endforelse
                </div>
                <div class="mt-3">{{ $jobs?->links() }}</div>
            @elseif ($user->isJobSeeker())
                <h2 class="font-heading text-lg font-bold text-slate-900">Applications</h2>
                <div class="mt-3 space-y-2">
                    @forelse ($applications as $application)
                        <article class="rounded-xl border border-slate-200 p-3">
                            <p class="font-semibold text-slate-900">{{ $application->job->title ?? 'Deleted job' }}</p>
                            <p class="text-xs text-slate-500">Status: {{ str_replace('_', ' ', $application->status) }}</p>
                        </article>
                    @empty
                        <p class="text-sm text-slate-600">No applications yet.</p>
                    @endforelse
                </div>
                <div class="mt-3">{{ $applications?->links() }}</div>

                <h3 class="mt-5 text-sm font-semibold uppercase tracking-wide text-slate-500">Resumes</h3>
                <ul class="mt-2 space-y-1 text-sm">
                    @forelse ($user->resumes as $resume)
                        <li><a href="{{ $resume->url }}" target="_blank" class="font-semibold text-emerald-700 hover:underline">{{ $resume->original_name }}</a></li>
                    @empty
                        <li class="text-slate-600">No resumes uploaded.</li>
                    @endforelse
                </ul>
            @endif
        </section>
    </div>
</x-app-layout>
