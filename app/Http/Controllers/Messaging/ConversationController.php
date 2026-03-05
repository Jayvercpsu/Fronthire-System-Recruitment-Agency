<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messaging\StoreMessageRequest;
use App\Models\Conversation;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function index(Request $request): View
    {
        $conversations = $this->buildConversationList($request);
        $activeConversation = $conversations->first();

        if ($activeConversation) {
            $this->markConversationAsRead($activeConversation, $request);
        }

        return view('dashboards.shared.chat.index', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation?->load([
                'messages.sender:id,first_name,last_name',
                'application.job:id,title,employer_id',
                'application.job.employer:id,first_name,last_name',
                'application.job.employer.employerProfile:id,user_id,company_name',
            ]),
        ]);
    }

    public function show(Conversation $conversation, Request $request): View
    {
        $this->authorize('view', $conversation);

        $conversations = $this->buildConversationList($request);
        $activeConversation = $conversations->firstWhere('id', $conversation->id);

        abort_if(! $activeConversation, 404);

        $this->markConversationAsRead($activeConversation, $request);

        return view('dashboards.shared.chat.index', [
            'conversations' => $conversations,
            'activeConversation' => $activeConversation->load([
                'messages.sender:id,first_name,last_name',
                'users:id,first_name,last_name',
                'application.job:id,title,employer_id',
                'application.job.employer:id,first_name,last_name',
                'application.job.employer.employerProfile:id,user_id,company_name',
            ]),
        ]);
    }

    public function storeMessage(StoreMessageRequest $request, Conversation $conversation): RedirectResponse|JsonResponse
    {
        $this->authorize('sendMessage', $conversation);

        $payload = [
            'sender_id' => $request->user()->id,
            'body' => $request->string('body')->toString() ?: null,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->store("chat-attachments/{$conversation->id}/{$request->user()->id}", 'public');

            $payload['attachment_path'] = $path;
            $payload['attachment_original_name'] = $file->getClientOriginalName();
            $payload['attachment_file_size'] = $file->getSize();
            $payload['attachment_mime_type'] = $file->getMimeType();
        }

        $message = $conversation->messages()->create($payload);

        $recipientIds = $conversation->participants()
            ->where('user_id', '!=', $request->user()->id)
            ->pluck('user_id');

        User::query()
            ->whereIn('id', $recipientIds)
            ->get()
            ->each(function (User $recipient) use ($conversation, $request, $message): void {
                $notificationBody = $message->body
                    ? "{$request->user()->full_name}: ".str($message->body)->limit(90)->toString()
                    : "{$request->user()->full_name} sent an attachment.";

                $recipient->notify(new SystemNotification(
                    title: 'New message',
                    body: $notificationBody,
                    url: route('chat.show', $conversation)
                ));
            });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $message->id,
                    'sender_id' => $message->sender_id,
                    'body_html' => $message->body_html,
                    'created_at_label' => $message->created_at?->format('M d, h:i A'),
                    'attachment_url' => $message->attachment_url,
                    'attachment_original_name' => $message->attachment_original_name,
                ],
                'toast' => 'Message sent.',
            ]);
        }

        return redirect()->route('chat.show', $conversation)->with('success', 'Message sent.');
    }

    private function buildConversationList(Request $request)
    {
        return Conversation::query()
            ->forUser($request->user())
            ->whereHas('application.job.employer')
            ->whereHas('application.jobSeeker')
            ->with([
                'users:id,first_name,last_name',
                'application.job:id,title,employer_id',
                'application.job.employer:id,first_name,last_name',
                'application.job.employer.employerProfile:id,user_id,company_name',
                'application.jobSeeker:id,first_name,last_name',
                'latestMessage.sender:id,first_name,last_name',
            ])
            ->withCount([
                'messages as unread_count' => function ($query) use ($request): void {
                    $query->whereNull('read_at')
                        ->where('sender_id', '!=', $request->user()->id);
                },
            ])
            ->withMax('messages', 'created_at')
            ->orderByDesc('messages_max_created_at')
            ->orderByDesc('updated_at')
            ->get();
    }

    private function markConversationAsRead(Conversation $conversation, Request $request): void
    {
        $conversation->messages()
            ->whereNull('read_at')
            ->where('sender_id', '!=', $request->user()->id)
            ->update(['read_at' => now()]);

        $conversation->participants()
            ->where('user_id', $request->user()->id)
            ->update(['last_read_at' => now()]);
    }
}
