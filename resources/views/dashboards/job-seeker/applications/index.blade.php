<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">My Applications</h1>
            <p class="mt-1 text-sm text-slate-600">Track status updates and recruiter feedback.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-3">
            <input name="search" class="form-input" value="{{ request('search') }}" placeholder="Search job title/location">
            <select name="status" class="form-input">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                @endforeach
            </select>
            <div class="flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Filter</button>
                @if (request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('job-seeker.applications.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <div class="mt-5 space-y-3">
        @forelse ($applications as $application)
            <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-heading text-lg font-bold text-slate-900">{{ $application->job->title }}</h2>
                        <p class="text-sm text-slate-600">{{ $application->job->location }} | {{ str_replace('_', ' ', $application->job->job_type) }}</p>
                        <p class="mt-1 text-xs text-slate-500">Employer: {{ $application->job->employer->full_name }}</p>
                    </div>
                    <span class="rounded-full px-2 py-1 text-[11px] font-semibold uppercase {{ in_array($application->status, ['hired', 'offer'], true) ? 'bg-emerald-100 text-emerald-700' : (in_array($application->status, ['rejected', 'withdrawn'], true) ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                        {{ str_replace('_', ' ', $application->status) }}
                    </span>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2">
                    <a href="{{ route('job-seeker.applications.show', $application) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View Timeline</a>
                    @if ($application->conversation)
                        <a href="{{ route('chat.show', $application->conversation) }}" class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Open Chat</a>
                    @endif
                </div>
            </article>
        @empty
            <section class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600">
                No applications found.
            </section>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</x-app-layout>
