<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Manage Users</h1>
            <p class="mt-1 text-sm text-slate-600">View employers and job seekers, then activate/deactivate or remove accounts.</p>
        </div>
    </x-slot>

    <section class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form method="GET" class="grid gap-3 sm:grid-cols-4">
            <input name="search" class="form-input sm:col-span-2" value="{{ request('search') }}" placeholder="Search name/email">
            <select name="role" class="form-input">
                <option value="">All roles</option>
                <option value="employer" @selected(request('role') === 'employer')>Employer</option>
                <option value="job_seeker" @selected(request('role') === 'job_seeker')>Job Seeker</option>
            </select>
            <select name="status" class="form-input">
                <option value="">All statuses</option>
                <option value="active" @selected(request('status') === 'active')>Active</option>
                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
            </select>
            <div class="sm:col-span-4 flex flex-wrap gap-2">
                <button class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700">Filter</button>
                @if (request()->filled('search') || request()->filled('role') || request()->filled('status'))
                    <a href="{{ route('admin.users.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Clear</a>
                @endif
            </div>
        </form>
    </section>

    <section class="mt-5 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">User</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Role</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-semibold text-slate-900">{{ $user->full_name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </td>
                            <td class="px-4 py-3 text-slate-700">{{ str_replace('_', ' ', $user->role) }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2 py-1 text-[11px] font-semibold uppercase {{ $user->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $user->is_active ? 'active' : 'inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <div class="inline-flex items-center gap-2">
                                    <a href="{{ route('admin.users.show', $user) }}" class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.status.update', $user) }}"
                                        data-confirm
                                        data-confirm-title="Confirm status update"
                                        data-confirm-message="{{ $user->is_active ? 'Deactivate this user account?' : 'Activate this user account?' }}"
                                        data-confirm-button="{{ $user->is_active ? 'Deactivate' : 'Activate' }}"
                                    >
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="is_active" value="{{ $user->is_active ? 0 : 1 }}">
                                        <button class="rounded-lg border border-amber-300 px-3 py-1.5 text-xs font-semibold text-amber-700 hover:bg-amber-50">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                                    </form>
                                    <form
                                        method="POST"
                                        action="{{ route('admin.users.destroy', $user) }}"
                                        data-confirm
                                        data-confirm-title="Delete user"
                                        data-confirm-message="Delete this user account?"
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
                            <td colspan="4" class="px-4 py-6 text-center text-sm text-slate-600">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</x-app-layout>
