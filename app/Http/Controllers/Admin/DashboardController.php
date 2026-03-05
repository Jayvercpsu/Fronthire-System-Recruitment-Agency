<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Inquiry;
use App\Models\Resume;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'users_total' => User::query()->count(),
                'employers_total' => User::query()->where('role', 'employer')->count(),
                'job_seekers_total' => User::query()->where('role', 'job_seeker')->count(),
                'inquiries_total' => Inquiry::query()->count(),
                'contacts_total' => Contact::query()->count(),
                'resumes_total' => Resume::query()->count(),
            ],
        ]);
    }
}
