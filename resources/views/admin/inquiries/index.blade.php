<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Inquiries</h1>
            <p class="mt-1 text-sm text-slate-600">View and manage employer and general inquiries.</p>
        </div>
    </x-slot>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Type</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Company/Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Date</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($inquiries as $inquiry)
                        <tr>
                            <td class="px-4 py-3 capitalize text-slate-700">{{ $inquiry->type }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $inquiry->email }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $inquiry->company_name ?: $inquiry->name ?: '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $inquiry->created_at->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.inquiries.show', $inquiry) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">No inquiries found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $inquiries->links() }}
    </div>
</x-app-layout>
