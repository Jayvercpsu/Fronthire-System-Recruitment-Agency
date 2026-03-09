<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobSeeker\StoreApplicationRequest;
use App\Models\Application;
use App\Models\Conversation;
use App\Models\Job;
use App\Models\Resume;
use App\Notifications\SystemNotification;
use App\Services\MediaStorageService;
use App\Support\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __construct(
        private readonly MediaStorageService $mediaStorage
    ) {}

    public function index(Request $request): View
    {
        $query = Application::query()
            ->where('job_seeker_id', $request->user()->id)
            ->with([
                'job:id,title,location,job_type,work_setup,employer_id',
                'job.employer:id,first_name,last_name',
                'conversation.latestMessage.sender:id,first_name,last_name',
            ])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->whereHas('job', function ($searchQuery) use ($search): void {
                $searchQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        return view('dashboards.job-seeker.applications.index', [
            'applications' => $query->paginate(10)->withQueryString(),
            'statuses' => Application::STATUSES,
        ]);
    }

    public function store(StoreApplicationRequest $request, Job $job): RedirectResponse
    {
        $this->authorize('apply', $job);
        $this->authorize('create', [Application::class, $job]);

        $exists = Application::query()
            ->where('job_id', $job->id)
            ->where('job_seeker_id', $request->user()->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'You already applied to this job.');
        }

        $resumeId = $request->filled('resume_id') ? $request->integer('resume_id') : null;

        if ($request->hasFile('resume')) {
            $file = $request->file('resume');
            $path = $this->mediaStorage->store($file, 'resumes/'.$request->user()->id);

            $uploadedResume = Resume::query()->create([
                'user_id' => $request->user()->id,
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);

            $resumeId = $uploadedResume->id;
        }

        $application = Application::query()->create([
            'job_id' => $job->id,
            'job_seeker_id' => $request->user()->id,
            'resume_id' => $resumeId,
            'status' => Application::STATUS_SUBMITTED,
            'cover_letter' => $request->string('cover_letter')->toString() ?: null,
        ]);

        $conversation = Conversation::query()->create([
            'application_id' => $application->id,
        ]);

        $conversation->participants()->createMany([
            ['user_id' => $job->employer_id],
            ['user_id' => $request->user()->id],
        ]);

        AuditLogger::forModel(
            model: $application,
            event: 'application_submitted',
            actor: $request->user(),
            newValues: [
                'resume_id' => $application->resume_id,
                'status' => Application::STATUS_SUBMITTED,
                'cover_letter' => $application->cover_letter,
            ],
            description: 'Application submitted by job seeker.'
        );

        $job->loadMissing('employer:id,first_name,last_name');
        $job->employer->notify(new SystemNotification(
            title: 'New application received',
            body: "{$request->user()->full_name} applied for {$job->title}.",
            url: route('employer.jobs.applicants.index', $job)
        ));

        return redirect()->route('job-seeker.applications.show', $application)->with('success', 'Application submitted.');
    }

    public function show(Application $application): View
    {
        $this->authorize('view', $application);

        return view('dashboards.job-seeker.applications.show', [
            'application' => $application->load([
                'job:id,title,description,requirements,location,job_type,work_setup,employer_id',
                'job.employer:id,first_name,last_name,email',
                'resume:id,user_id,file_path,original_name',
                'conversation.latestMessage',
                'auditLogs.actor:id,first_name,last_name',
            ]),
        ]);
    }

    public function withdraw(Application $application, Request $request): RedirectResponse
    {
        $this->authorize('view', $application);

        if ($application->job_seeker_id !== $request->user()->id) {
            abort(403);
        }

        if (in_array($application->status, [Application::STATUS_HIRED, Application::STATUS_REJECTED, Application::STATUS_WITHDRAWN], true)) {
            return back()->with('error', 'This application can no longer be withdrawn.');
        }

        $oldStatus = $application->status;
        $application->status = Application::STATUS_WITHDRAWN;
        $application->save();

        AuditLogger::forModel(
            model: $application,
            event: 'application_withdrawn',
            actor: $request->user(),
            oldValues: ['status' => $oldStatus],
            newValues: ['status' => $application->status],
            description: 'Application withdrawn by job seeker.'
        );

        return back()->with('success', 'Application withdrawn.');
    }
}
