<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEmployerInquiryRequest;
use App\Http\Requests\StoreGeneralInquiryRequest;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;

class InquiryController extends Controller
{
    public function storeGeneral(StoreGeneralInquiryRequest $request): RedirectResponse
    {
        Inquiry::query()->create([
            'user_id' => $request->user()?->id,
            'name' => $request->string('name')->toString(),
            'email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString() ?: null,
            'message' => $request->string('message')->toString(),
            'type' => 'general',
        ]);

        return back()->with('success', 'Your inquiry was submitted. Our team will contact you soon.');
    }

    public function storeEmployer(StoreEmployerInquiryRequest $request): RedirectResponse
    {
        Inquiry::query()->create([
            'user_id' => $request->user()?->id,
            'company_name' => $request->string('company_name')->toString(),
            'email' => $request->string('email')->toString(),
            'phone' => $request->string('phone')->toString() ?: null,
            'message' => $request->string('message')->toString(),
            'type' => 'employer',
        ]);

        return back()->with('success', 'Thanks for your request. We will follow up with staffing options.');
    }
}
