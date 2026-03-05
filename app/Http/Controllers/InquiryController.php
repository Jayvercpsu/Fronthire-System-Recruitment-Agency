<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerInquiryRequest;
use App\Http\Requests\StoreGeneralInquiryRequest;
use App\Models\Inquiry;
use App\Models\User;
use App\Notifications\SystemNotification;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    public function storeGeneral(StoreGeneralInquiryRequest $request): RedirectResponse
    {
        $inquiry = Inquiry::query()->create([
            'user_id' => $request->user()?->id,
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString() ?: null,
            'message' => $request->string('message')->toString(),
            'type' => 'general',
        ]);

        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(new SystemNotification(
                title: 'New general inquiry',
                body: "New inquiry from {$inquiry->email}.",
                url: route('admin.inquiries.show', $inquiry)
            )));

        return back()->with('success', 'Your inquiry was submitted. Our team will contact you soon.');
    }

    public function storeEmployer(StoreEmployerInquiryRequest $request): RedirectResponse
    {
        $inquiry = Inquiry::query()->create([
            'user_id' => $request->user()?->id,
            'company_name' => $request->string('company_name')->toString(),
            'email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString() ?: null,
            'message' => $request->string('message')->toString(),
            'type' => 'employer',
        ]);

        User::query()
            ->where('role', 'admin')
            ->get()
            ->each(fn (User $admin) => $admin->notify(new SystemNotification(
                title: 'New employer inquiry',
                body: "New employer inquiry from {$inquiry->email}.",
                url: route('admin.inquiries.show', $inquiry)
            )));

        return back()->with('success', 'Thanks for your request. We will follow up with staffing options.');
    }
}
