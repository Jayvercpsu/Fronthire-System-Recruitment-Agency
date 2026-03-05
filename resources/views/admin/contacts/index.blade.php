<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Contact Messages</h1>
            <p class="mt-1 text-sm text-slate-600">Review website contact submissions.</p>
        </div>
    </x-slot>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Name</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Email</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Phone</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Date</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($contacts as $contact)
                        <tr>
                            <td class="px-4 py-3 text-slate-700">{{ $contact->name }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $contact->email }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $contact->phone ?: '-' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $contact->created_at->format('M d, Y h:i A') }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="rounded-lg border border-slate-200 px-3 py-1.5 font-semibold text-slate-700 hover:border-emerald-200 hover:bg-emerald-50 hover:text-emerald-700">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-500">No contact messages found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $contacts->links() }}
    </div>
</x-app-layout>
