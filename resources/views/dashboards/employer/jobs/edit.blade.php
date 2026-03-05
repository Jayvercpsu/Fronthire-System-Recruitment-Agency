<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Edit Job</h1>
            <p class="mt-1 text-sm text-slate-600">Update posting details and status.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <form method="POST" action="{{ route('employer.jobs.update', $job) }}">
            @method('PATCH')
            @include('dashboards.employer.jobs._form', ['submitLabel' => 'Save Changes'])
        </form>
    </section>
</x-app-layout>

