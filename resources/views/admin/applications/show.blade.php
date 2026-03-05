<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Application Detail</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $application->jobSeeker->full_name }} | {{ $application->job->title }}</p>
            </div>
            <a href="{{ route('admin.applications.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="font-heading text-lg font-bold text-slate-900">Application Audit Log</h2>
            <ol class="mt-4 space-y-3 border-l border-slate-200 pl-4">
                <li class="relative">
                    <span class="absolute -left-[1.1rem] top-1.5 h-2.5 w-2.5 rounded-full bg-emerald-600"></span>
                    <p class="text-sm font-semibold text-slate-900">Application Submitted</p>
                    <p class="text-xs text-slate-500">{{ $application->created_at?->format('M d, Y h:i A') }}</p>
                </li>
                @foreach ($application->auditLogs as $audit)
                    <li class="relative">
                        <span class="absolute -left-[1.1rem] top-1.5 h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                        <p class="text-sm font-semibold text-slate-900">{{ \Illuminate\Support\Str::headline(str_replace('_', ' ', $audit->event)) }}</p>
                        @if ($audit->new_values['status'] ?? false)
                            <p class="text-xs text-slate-600">Status: {{ str_replace('_', ' ', $audit->new_values['status']) }}</p>
                        @endif
                        @if ($audit->description)
                            <p class="text-xs text-slate-600">{{ $audit->description }}</p>
                        @endif
                        <p class="text-xs text-slate-500">By: {{ $audit->actor?->full_name ?? 'System' }} | {{ $audit->created_at?->format('M d, Y h:i A') }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Summary</h2>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold">Applicant:</span> {{ $application->jobSeeker->full_name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $application->jobSeeker->email }}</p>
                <p><span class="font-semibold">Employer:</span> {{ $application->job->employer->full_name }}</p>
                <p><span class="font-semibold">Current Status:</span> {{ str_replace('_', ' ', $application->status) }}</p>
            </div>

            @if ($application->cover_letter)
                <h3 class="mt-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Cover Letter</h3>
                <p class="mt-2 whitespace-pre-line text-sm text-slate-700">{{ $application->cover_letter }}</p>
            @endif

            @if ($application->jobSeeker->resumes->isNotEmpty())
                <h3 class="mt-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Resume</h3>
                @php($latestResume = $application->jobSeeker->resumes->sortByDesc('id')->first())
                <a href="{{ $latestResume->url }}" target="_blank" class="mt-2 inline-flex rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">{{ $latestResume->original_name }}</a>
            @endif
        </aside>
    </div>
</x-app-layout>

