<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Application Timeline</h1>
                <p class="mt-1 text-sm text-slate-600">{{ $application->job->title }} | {{ $application->job->location }}</p>
            </div>
            <a href="{{ route('job-seeker.applications.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back</a>
        </div>
    </x-slot>

    <div class="grid gap-6 lg:grid-cols-3">
        <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="font-heading text-lg font-bold text-slate-900">Status Timeline</h2>

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
                        @if($audit->new_values['status'] ?? false)
                            <p class="text-xs text-slate-600">Status: {{ str_replace('_', ' ', $audit->new_values['status']) }}</p>
                        @endif
                        @if($audit->description)
                            <p class="text-xs text-slate-600">{{ $audit->description }}</p>
                        @endif
                        <p class="text-xs text-slate-500">{{ $audit->created_at?->format('M d, Y h:i A') }}</p>
                    </li>
                @endforeach
            </ol>
        </section>

        <aside class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <h2 class="font-heading text-lg font-bold text-slate-900">Summary</h2>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold">Current Status:</span> {{ str_replace('_', ' ', $application->status) }}</p>
                <p><span class="font-semibold">Employer:</span> {{ $application->job->employer->full_name }}</p>
                <p><span class="font-semibold">Work Setup:</span> {{ str_replace('_', ' ', $application->job->work_setup) }}</p>
            </div>

            @if ($application->resume)
                <div class="mt-4">
                    <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Submitted Resume</h3>
                    <a href="{{ $application->resume->url }}" target="_blank" rel="noopener" class="mt-2 inline-flex rounded-xl border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                        {{ $application->resume->original_name }}
                    </a>
                </div>
            @endif

            @if ($application->cover_letter)
                <h3 class="mt-4 text-sm font-semibold uppercase tracking-wide text-slate-500">Cover Letter</h3>
                <p class="mt-2 whitespace-pre-line text-sm text-slate-700">{{ $application->cover_letter }}</p>
            @endif

            <div class="mt-5 space-y-2">
                @if ($application->conversation)
                    <a href="{{ route('chat.show', $application->conversation) }}" class="block rounded-xl border border-emerald-300 px-4 py-2 text-center text-sm font-semibold text-emerald-700 hover:bg-emerald-50">Open Chat</a>
                @endif

                <form
                    method="POST"
                    action="{{ route('job-seeker.applications.withdraw', $application) }}"
                    data-confirm
                    data-confirm-title="Withdraw application"
                    data-confirm-message="Withdraw this application?"
                    data-confirm-button="Withdraw"
                >
                    @csrf
                    @method('PATCH')
                    <button class="w-full rounded-xl border border-rose-300 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-50">Withdraw Application</button>
                </form>
            </div>
        </aside>
    </div>
</x-app-layout>
