<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Manage Jobs</h1>
                <p class="mt-1 text-sm text-slate-600">Draft, publish, close, and monitor job postings.</p>
            </div>
            <a href="{{ route('employer.jobs.create') }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700">Create Job</a>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-3">
            <input type="text" name="search" class="form-input" placeholder="Search title/location" value="{{ request('search') }}">
            <select name="status" class="form-input">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                @endforeach
            </select>
            <div class="flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Filter</button>
                @if (request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('employer.jobs.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Title</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Type</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Applicants</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jobs as $job)
                        <tr>
                            <td class="px-4 py-3 align-top">
                                <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                                <p class="text-xs text-slate-500">{{ $job->location }}</p>
                            </td>
                            <td class="px-4 py-3 align-top text-slate-600">{{ str_replace('_', ' ', $job->job_type) }} / {{ str_replace('_', ' ', $job->work_setup) }}</td>
                            <td class="px-4 py-3 align-top">
                                <span class="rounded-full px-2 py-1 text-[11px] font-semibold uppercase {{ $job->status === 'published' ? 'bg-emerald-100 text-emerald-700' : ($job->status === 'closed' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                                    {{ str_replace('_', ' ', $job->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 align-top text-slate-700">{{ $job->applications_count }}</td>
                            <td class="px-4 py-3 align-top text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('employer.jobs.applicants.index', $job) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">Applicants</a>
                                    <a href="{{ route('employer.jobs.edit', $job) }}" class="rounded-lg border border-emerald-300 px-3 py-1.5 text-xs font-semibold text-emerald-700 hover:bg-emerald-50">Edit</a>
                                    <form
                                        method="POST"
                                        action="{{ route('employer.jobs.destroy', $job) }}"
                                        data-confirm
                                        data-confirm-title="Delete job"
                                        data-confirm-message="Delete this job?"
                                        data-confirm-button="Delete"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-sm text-slate-600">No jobs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-4">
        {{ $jobs->links() }}
    </div>
</x-app-layout>
