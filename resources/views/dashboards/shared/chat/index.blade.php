<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-heading text-2xl font-bold text-slate-900">Messages</h1>
            <p class="mt-1 text-sm text-slate-600">Secure chat tied to job applications.</p>
        </div>
    </x-slot>

    <div class="grid gap-4 lg:grid-cols-3">
        <aside class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-4 py-3">
                <h2 class="font-heading text-lg font-bold text-slate-900">Conversations</h2>
            </div>
            <div class="max-h-[70vh] overflow-y-auto">
                @forelse ($conversations as $conversation)
                    @php
                        $application = $conversation->application;
                        $job = $application?->job;
                        $employer = $job?->employer;
                        $jobSeeker = $application?->jobSeeker;
                        $otherParticipant = $conversation->users->firstWhere('id', '!=', auth()->id());
                        $isActive = $activeConversation && $activeConversation->id === $conversation->id;
                        $otherUser = $otherParticipant ?: ($job && $job->employer_id === auth()->id() ? $jobSeeker : $employer);
                        $companyName = $employer?->employerProfile?->company_name
                            ?? $employer?->full_name
                            ?? 'Company';
                        $jobTitle = $job?->title ?? 'Application Chat';
                    @endphp
                    <a href="{{ route('chat.show', $conversation) }}" class="block border-b border-slate-100 px-4 py-3 {{ $isActive ? 'bg-emerald-50' : 'hover:bg-slate-50' }}">
                        <div class="flex items-center justify-between gap-2">
                            <p class="font-semibold text-slate-900">{{ $otherUser?->full_name ?? 'Conversation' }}</p>
                            @if ($conversation->unread_count > 0)
                                <span class="rounded-full bg-emerald-600 px-2 py-0.5 text-[11px] font-semibold text-white">{{ $conversation->unread_count }}</span>
                            @endif
                        </div>
                        <p class="mt-1 text-xs text-slate-500">{{ $jobTitle }} | {{ $companyName }}</p>
                        @if ($conversation->latestMessage)
                            <p class="mt-1 text-xs text-slate-600">
                                {{ \Illuminate\Support\Str::limit($conversation->latestMessage->body ?: ($conversation->latestMessage->attachment_original_name ? '[Attachment] '.$conversation->latestMessage->attachment_original_name : ''), 70) }}
                            </p>
                        @endif
                    </a>
                @empty
                    <p class="p-4 text-sm text-slate-600">No conversations yet.</p>
                @endforelse
            </div>
        </aside>

        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
            @if ($activeConversation)
                <div class="border-b border-slate-200 px-4 py-3">
                    @php
                        $activeApplication = $activeConversation->application;
                        $activeJob = $activeApplication?->job;
                        $activeEmployer = $activeJob?->employer;
                        $activeJobSeeker = $activeApplication?->jobSeeker;
                        $activeOtherParticipant = $activeConversation->users->firstWhere('id', '!=', auth()->id());
                        $otherUser = $activeJob && $activeJob->employer_id === auth()->id()
                            ? $activeJobSeeker
                            : $activeEmployer;
                        $otherUser = $activeOtherParticipant ?: $otherUser;
                        $companyName = $activeEmployer?->employerProfile?->company_name
                            ?? $activeEmployer?->full_name
                            ?? 'Company';
                        $jobTitle = $activeJob?->title ?? 'Application Chat';
                    @endphp
                    <h2 class="font-heading text-lg font-bold text-slate-900">{{ $otherUser?->full_name ?? 'Conversation' }}</h2>
                    <p class="text-xs text-slate-500">{{ $jobTitle }} | {{ $companyName }}</p>
                </div>

                <div data-chat-messages class="max-h-[56vh] space-y-3 overflow-y-auto p-4">
                    @forelse ($activeConversation->messages as $message)
                        <div class="flex {{ $message->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[80%] rounded-2xl px-3 py-2 text-sm {{ $message->sender_id === auth()->id() ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-800' }}">
                                @if ($message->body)
                                    <p class="break-words">{!! $message->body_html !!}</p>
                                @endif

                                @if ($message->attachment_url)
                                    <a href="{{ $message->attachment_url }}" target="_blank" rel="noopener" class="mt-2 inline-flex rounded-lg border {{ $message->sender_id === auth()->id() ? 'border-emerald-100 text-emerald-50 hover:bg-emerald-500' : 'border-slate-300 text-blue-600 hover:bg-slate-50' }} px-2 py-1 text-xs font-semibold">
                                        {{ $message->attachment_original_name ?? 'Attachment' }}
                                    </a>
                                @endif
                                <p class="mt-1 text-[10px] {{ $message->sender_id === auth()->id() ? 'text-emerald-100' : 'text-slate-500' }}">{{ $message->created_at?->format('M d, h:i A') }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-slate-600">No messages yet. Start the conversation.</p>
                    @endforelse
                </div>

                <form method="POST" action="{{ route('chat.messages.store', $activeConversation) }}" enctype="multipart/form-data" data-chat-form class="border-t border-slate-200 p-4">
                    @csrf
                    <div class="space-y-2">
                        <div class="grid grid-cols-[auto_1fr_auto] items-center gap-2">
                            <input
                                id="chat-attachment-input"
                                type="file"
                                name="attachment"
                                accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.webp,.txt"
                                class="hidden"
                                data-chat-attachment-input
                            >
                            <button
                                type="button"
                                data-chat-attachment-trigger
                                class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-300 text-slate-600 hover:border-emerald-300 hover:bg-emerald-50 hover:text-emerald-700"
                                title="Attach file"
                                aria-label="Attach file"
                            >
                                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.44 11.05l-8.49 8.49a5.5 5.5 0 01-7.78-7.78l8.48-8.49a3.5 3.5 0 114.95 4.95L9.7 17.13a1.5 1.5 0 11-2.12-2.12l7.43-7.43" />
                                </svg>
                            </button>
                            <input name="body" class="form-input" placeholder="Type a message...">
                            <button type="submit" data-chat-submit class="h-11 rounded-xl bg-emerald-600 px-4 text-sm font-semibold text-white hover:bg-emerald-700">Send</button>
                        </div>
                        <div class="flex items-center justify-between gap-2 text-xs text-slate-500">
                            <p>Attachment max size: 5MB</p>
                            <p data-chat-attachment-name class="truncate text-right">No file selected</p>
                        </div>
                    </div>
                    @error('body') <p class="form-error mt-1">{{ $message }}</p> @enderror
                    @error('attachment') <p class="form-error mt-1">{{ $message }}</p> @enderror
                </form>
            @else
                <div class="p-6 text-center text-sm text-slate-600">Select a conversation to start messaging.</div>
            @endif
        </section>
    </div>
</x-app-layout>
