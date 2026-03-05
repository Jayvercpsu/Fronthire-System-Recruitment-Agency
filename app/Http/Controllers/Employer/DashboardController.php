<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Conversation;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $jobsQuery = Job::query()->where('employer_id', $user->id);
        $applicationsQuery = Application::query()->whereHas('job', function ($query) use ($user): void {
            $query->where('employer_id', $user->id);
        });

        $stats = [
            'active_jobs' => (clone $jobsQuery)->where('status', Job::STATUS_PUBLISHED)->count(),
            'total_applicants' => (clone $applicationsQuery)->count(),
            'shortlisted' => (clone $applicationsQuery)->where('status', Application::STATUS_SHORTLISTED)->count(),
            'interviews' => (clone $applicationsQuery)->where('status', Application::STATUS_INTERVIEW)->count(),
            'hired' => (clone $applicationsQuery)->where('status', Application::STATUS_HIRED)->count(),
            'unread_messages' => Conversation::query()
                ->forUser($user)
                ->whereHas('messages', function ($query) use ($user): void {
                    $query->whereNull('read_at')
                        ->where('sender_id', '!=', $user->id);
                })
                ->count(),
        ];

        $recentJobs = Job::query()
            ->where('employer_id', $user->id)
            ->withCount('applications')
            ->latest()
            ->take(5)
            ->get();

        $recentApplicants = Application::query()
            ->whereHas('job', function ($query) use ($user): void {
                $query->where('employer_id', $user->id);
            })
            ->with(['job:id,title', 'jobSeeker:id,first_name,last_name,email'])
            ->latest()
            ->take(6)
            ->get();

        return view('dashboards.employer.index', [
            'stats' => $stats,
            'recentJobs' => $recentJobs,
            'recentApplicants' => $recentApplicants,
        ]);
    }
}

