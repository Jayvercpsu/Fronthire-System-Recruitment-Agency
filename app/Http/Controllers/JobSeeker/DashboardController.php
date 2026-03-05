<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $applicationsQuery = Application::query()->where('job_seeker_id', $request->user()->id);

        $stats = [
            'applications_sent' => (clone $applicationsQuery)->count(),
            'under_review' => (clone $applicationsQuery)->where('status', Application::STATUS_UNDER_REVIEW)->count(),
            'interviews' => (clone $applicationsQuery)->where('status', Application::STATUS_INTERVIEW)->count(),
            'offers' => (clone $applicationsQuery)->where('status', Application::STATUS_OFFER)->count(),
            'hired' => (clone $applicationsQuery)->where('status', Application::STATUS_HIRED)->count(),
        ];

        $recentApplications = Application::query()
            ->where('job_seeker_id', $request->user()->id)
            ->with(['job:id,title,location,job_type,work_setup,employer_id', 'job.employer:id,first_name,last_name'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboards.job-seeker.index', [
            'stats' => $stats,
            'recentApplications' => $recentApplications,
        ]);
    }
}

