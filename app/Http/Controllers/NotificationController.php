<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        return view('dashboards.shared.notifications.index', [
            'notifications' => $request->user()
                ->notifications()
                ->latest()
                ->paginate(12),
        ]);
    }

    public function markAllRead(Request $request): RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return back()->with('success', 'All notifications marked as read.');
    }

    public function markRead(Request $request, string $notification): RedirectResponse
    {
        /** @var DatabaseNotification|null $target */
        $target = $request->user()
            ->notifications()
            ->where('id', $notification)
            ->first();

        abort_unless($target !== null, 404);

        if ($target->read_at === null) {
            $target->markAsRead();
        }

        $url = is_array($target->data) ? ($target->data['url'] ?? null) : null;

        if (is_string($url) && str_starts_with($url, url('/'))) {
            return redirect()->to($url);
        }

        return back();
    }
}

