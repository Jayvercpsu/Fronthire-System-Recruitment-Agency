<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Create Job</h1>
            <p class="mt-1 text-sm text-slate-600">Publish a new role for job seekers.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="POST" action="{{ route('employer.jobs.store') }}">
            @include('dashboards.employer.jobs._form', ['submitLabel' => 'Create Job'])
        </form>
    </section>
</x-app-layout>

