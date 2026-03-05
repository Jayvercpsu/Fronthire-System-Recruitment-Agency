<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\UpdateApplicationStatusRequest;
use App\Models\Application;
use App\Models\Job;
use App\Notifications\SystemNotification;
use App\Support\AuditLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ApplicantController extends Controller
{
    public function index(Job $job, Request $request): View
    {
        $this->authorize('manageApplicants', $job);

        $query = $job->applications()
            ->with([
                'jobSeeker:id,first_name,last_name,email,headline,bio,skills,location',
                'jobSeeker.resumes:id,user_id,file_path,original_name',
                'resume:id,user_id,file_path,original_name',
                'jobSeeker.education',
                'jobSeeker.experiences',
                'conversation.latestMessage.sender:id,first_name,last_name',
            ])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->whereHas('jobSeeker', function ($searchQuery) use ($search): void {
                $searchQuery->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10)->withQueryString();
        $requiredSkills = collect($job->required_skills ?? [])
            ->map(static fn (mixed $skill): string => trim((string) $skill))
            ->filter()
            ->values();

        $applications->getCollection()->transform(function (Application $application) use ($requiredSkills): Application {
            $candidateSkills = collect($application->jobSeeker->skills ?? [])
                ->map(static fn (mixed $skill): string => Str::lower(trim((string) $skill)))
                ->filter()
                ->values();

            $matchedSkills = $requiredSkills->filter(
                static fn (string $skill): bool => $candidateSkills->contains(Str::lower($skill))
            )->values();

            $missingSkills = $requiredSkills->reject(
                static fn (string $skill): bool => $candidateSkills->contains(Str::lower($skill))
            )->values();

            $application->setAttribute('skill_qualification', [
                'required_count' => $requiredSkills->count(),
                'matched' => $matchedSkills->all(),
                'missing' => $missingSkills->all(),
                'match_percent' => $requiredSkills->isNotEmpty()
                    ? (int) round(($matchedSkills->count() / $requiredSkills->count()) * 100)
                    : null,
            ]);

            return $application;
        });

        return view('dashboards.employer.jobs.applicants', [
            'job' => $job,
            'applications' => $applications,
            'statuses' => Application::STATUSES,
        ]);
    }

    public function update(Job $job, Application $application, UpdateApplicationStatusRequest $request): RedirectResponse
    {
        $this->authorize('manageApplicants', $job);

        abort_unless($application->job_id === $job->id, 404);
        $this->authorize('updateStatus', $application);

        $oldValues = [
            'status' => $application->status,
            'internal_notes' => $application->internal_notes,
        ];

        $application->status = $request->string('status')->toString();
        $application->internal_notes = $request->string('internal_notes')->toString() ?: null;
        $application->save();

        AuditLogger::forModel(
            model: $application,
            event: 'application_status_updated',
            actor: $request->user(),
            oldValues: $oldValues,
            newValues: [
                'status' => $application->status,
                'internal_notes' => $application->internal_notes,
            ],
            description: "Application status changed for {$application->jobSeeker->full_name}."
        );

        if ($oldValues['status'] !== $application->status) {
            $application->jobSeeker->notify(new SystemNotification(
                title: 'Application status updated',
                body: "Your application for {$job->title} is now {$application->status_label}.",
                url: route('job-seeker.applications.show', $application)
            ));
        }

        return back()->with('success', 'Application status updated.');
    }
}
