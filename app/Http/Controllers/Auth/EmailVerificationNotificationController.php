<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class EmailVerificationNotificationController extends Controller
{
    /**
     * Send a new email verification notification.
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        try {
            $request->user()->sendEmailVerificationNotification();
        } catch (Throwable $exception) {
            Log::error('Failed sending verification email.', [
                'user_id' => $request->user()->id,
                'email' => $request->user()->email,
                'error' => $exception->getMessage(),
            ]);

            return back()->withErrors([
                'email_verification' => 'Unable to send verification email right now. Please try again in a minute.',
            ]);
        }

        return back()->with('status', 'verification-link-sent');
    }
}
