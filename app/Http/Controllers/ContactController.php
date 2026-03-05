<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\RedirectResponse;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request): RedirectResponse
    {
        $contact = Contact::query()->create($request->validated());

        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(new SystemNotification(
                title: 'New contact message',
                body: "New message from {$contact->email}.",
                url: route('admin.contacts.show', $contact)
            )));

        return back()->with('success', 'Message sent successfully. We will get back to you shortly.');
    }
}
