<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Inquiry Detail</h1>
                <p class="mt-1 text-sm text-slate-600">Review submission and manage this inquiry.</p>
            </div>
            <a href="{{ route('admin.inquiries.index') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">Back</a>
        </div>
    </x-slot>

    <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <dl class="grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Type</dt>
                <dd class="mt-1 text-sm font-semibold capitalize text-slate-900">{{ $inquiry->type }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Email</dt>
                <dd class="mt-1 text-sm font-semibold text-slate-900">{{ $inquiry->email }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Company Name</dt>
                <dd class="mt-1 text-sm text-slate-700">{{ $inquiry->company_name ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Name</dt>
                <dd class="mt-1 text-sm text-slate-700">{{ $inquiry->name ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Phone</dt>
                <dd class="mt-1 text-sm text-slate-700">{{ $inquiry->phone ?: '-' }}</dd>
            </div>
            <div>
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Submitted</dt>
                <dd class="mt-1 text-sm text-slate-700">{{ $inquiry->created_at->format('M d, Y h:i A') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs uppercase tracking-[0.12em] text-slate-500">Message</dt>
                <dd class="mt-1 whitespace-pre-line rounded-xl bg-slate-50 p-4 text-sm text-slate-700">{{ $inquiry->message }}</dd>
            </div>
        </dl>

        <form
            method="POST"
            action="{{ route('admin.inquiries.destroy', $inquiry) }}"
            class="mt-6"
            data-confirm
            data-confirm-title="Delete inquiry"
            data-confirm-message="Delete this inquiry?"
            data-confirm-button="Delete"
        >
            @csrf
            @method('DELETE')
            <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2 text-sm font-semibold text-rose-700 hover:bg-rose-100">Delete Inquiry</button>
        </form>
    </div>
</x-app-layout>
