<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'employers_total' => User::query()->where('role', 'employer')->count(),
                'job_seekers_total' => User::query()->where('role', 'job_seeker')->count(),
                'jobs_total' => Job::query()->count(),
                'applications_total' => Application::query()->count(),
                'active_jobs' => Job::query()->where('status', Job::STATUS_PUBLISHED)->count(),
                'hired_total' => Application::query()->where('status', Application::STATUS_HIRED)->count(),
            ],
        ]);
    }
}
