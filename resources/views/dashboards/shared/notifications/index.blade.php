<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h1 class="font-heading text-2xl font-bold text-slate-900">Notifications</h1>
                <p class="mt-1 text-sm text-slate-600">Stay updated with new applications, status changes, and messages.</p>
            </div>
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('dashboard') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Back</a>
                @if (auth()->user()->unreadNotifications()->count() > 0)
                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        @method('PATCH')
                        <button class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                            Mark All Read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </x-slot>

    <section class="space-y-3">
        @forelse ($notifications as $notification)
            @php($payload = is_array($notification->data) ? $notification->data : [])
            <article class="rounded-2xl border {{ $notification->read_at ? 'border-slate-200 bg-white' : 'border-emerald-200 bg-emerald-50/40' }} p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-heading text-lg font-bold text-slate-900">{{ $payload['title'] ?? 'Notification' }}</h2>
                        <p class="mt-2 text-sm text-slate-700">{{ $payload['body'] ?? 'You have a new update.' }}</p>
                        <p class="mt-2 text-xs text-slate-500">{{ $notification->created_at?->diffForHumans() }}</p>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        @if ($notification->read_at === null)
                            <span class="rounded-full bg-emerald-100 px-2 py-1 text-[11px] font-semibold uppercase text-emerald-700">Unread</span>
                        @endif

                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="rounded-lg border border-slate-300 px-3 py-1.5 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                                {{ ! empty($payload['url']) ? ($notification->read_at ? 'Open' : 'Open & Mark Read') : 'Mark Read' }}
                            </button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <section class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-600">
                No notifications yet.
            </section>
        @endforelse
    </section>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</x-app-layout>
