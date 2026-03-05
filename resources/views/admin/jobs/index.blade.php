<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Manage Jobs</h1>
            <p class="mt-1 text-sm text-slate-600">Moderate job posts, force close roles, or remove spam listings.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-3">
            <input name="search" class="form-input sm:col-span-2" value="{{ request('search') }}" placeholder="Search title/employer/location">
            <select name="status" class="form-input">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                @endforeach
            </select>
            <div class="sm:col-span-3 flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Filter</button>
                @if (request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.jobs.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Job</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Employer</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Applicants</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($jobs as $job)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ $job->title }}</p>
                                <p class="text-xs text-slate-500">{{ $job->location }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $job->employer->full_name }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-1 text-[11px] font-semibold uppercase {{ $job->status === 'published' ? 'bg-emerald-100 text-emerald-700' : ($job->status === 'closed' ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700') }}">
                                    {{ str_replace('_', ' ', $job->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ $job->applications_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <form
                                        method="POST"
                                        action="{{ route('admin.jobs.status.update', $job) }}"
                                        data-confirm
                                        data-confirm-title="Force close job"
                                        data-confirm-message="Force close this job post?"
                                        data-confirm-button="Force Close"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="closed">
                                        <button class="rounded-lg border border-amber-300 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-50">Force Close</button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.jobs.destroy', $job) }}"
                                        data-confirm
                                        data-confirm-title="Remove job post"
                                        data-confirm-message="Remove this job post?"
                                        data-confirm-button="Remove"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="rounded-lg border border-rose-300 px-3 py-1.5 text-xs font-semibold text-rose-700 hover:bg-rose-50">Remove</button>
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
