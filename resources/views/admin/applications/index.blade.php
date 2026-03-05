<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Manage Applications</h1>
            <p class="mt-1 text-sm text-slate-600">Review all candidate applications and audit trails.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-3">
            <input name="search" class="form-input sm:col-span-2" value="{{ request('search') }}" placeholder="Search applicant/job">
            <select name="status" class="form-input">
                <option value="">All statuses</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ str_replace('_', ' ', $status) }}</option>
                @endforeach
            </select>
            <div class="sm:col-span-3 flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Filter</button>
                @if (request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('admin.applications.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Applicant</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Job</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($applications as $application)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ $application->jobSeeker->full_name }}</p>
                                <p class="text-xs text-slate-500">{{ $application->jobSeeker->email }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ $application->job->title }}</p>
                                <p class="text-xs text-slate-500">{{ $application->job->employer->full_name }}</p>
                            </td>
                            <td class="px-4 py-3">
                                <span class="rounded-full bg-slate-100 px-2 py-1 text-[11px] font-semibold uppercase text-slate-700">{{ str_replace('_', ' ', $application->status) }}</span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.applications.show', $application) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-600">No applications found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</x-app-layout>
