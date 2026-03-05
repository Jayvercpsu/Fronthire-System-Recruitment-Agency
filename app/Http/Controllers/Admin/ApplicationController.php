<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $query = Application::query()
            ->with([
                'job:id,title,employer_id',
                'job.employer:id,first_name,last_name',
                'jobSeeker:id,first_name,last_name,email',
            ])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($searchQuery) use ($search): void {
                $searchQuery->whereHas('job', function ($jobQuery) use ($search): void {
                    $jobQuery->where('title', 'like', "%{$search}%");
                })->orWhereHas('jobSeeker', function ($userQuery) use ($search): void {
                    $userQuery->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            });
        }

        return view('admin.applications.index', [
            'applications' => $query->paginate(15)->withQueryString(),
            'statuses' => Application::STATUSES,
        ]);
    }

    public function show(Application $application): View
    {
        return view('admin.applications.show', [
            'application' => $application->load([
                'job:id,title,description,location,job_type,work_setup,employer_id',
                'job.employer:id,first_name,last_name,email',
                'jobSeeker:id,first_name,last_name,email,headline,bio,skills,location',
                'jobSeeker.resumes:id,user_id,file_path,original_name',
                'auditLogs.actor:id,first_name,last_name',
            ]),
        ]);
    }
}

