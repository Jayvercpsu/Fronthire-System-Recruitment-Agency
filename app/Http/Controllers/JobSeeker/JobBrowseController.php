<?php

namespace App\Http\Controllers\JobSeeker;

use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JobBrowseController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = Job::query()
            ->visibleToSeekers()
            ->with(['employer:id,first_name,last_name', 'employer.employerProfile'])
            ->latest('published_at');

        if ($request->filled('keyword')) {
            $keyword = $request->string('keyword')->toString();

            $query->where(function ($searchQuery) use ($keyword): void {
                $searchQuery->where('title', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('requirements', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->string('location')->toString().'%');
        }

        if ($request->filled('job_type') && in_array($request->string('job_type')->toString(), Job::JOB_TYPES, true)) {
            $query->where('job_type', $request->string('job_type')->toString());
        }

        if ($request->filled('work_setup') && in_array($request->string('work_setup')->toString(), Job::WORK_SETUPS, true)) {
            $query->where('work_setup', $request->string('work_setup')->toString());
        }

        $jobs = $query->paginate(10)->withQueryString();
        $jobIds = $jobs->getCollection()->pluck('id');

        $applicationsByJob = $user->applications()
            ->whereIn('job_id', $jobIds)
            ->get(['id', 'job_id', 'status'])
            ->keyBy('job_id');

        $viewedJobIds = $user->jobViews()
            ->whereIn('job_id', $jobIds)
            ->pluck('job_id')
            ->map(static fn ($id): int => (int) $id)
            ->values();

        return view('dashboards.job-seeker.jobs.index', [
            'jobs' => $jobs,
            'applicationsByJob' => $applicationsByJob,
            'viewedJobIds' => $viewedJobIds,
            'jobTypes' => Job::JOB_TYPES,
            'workSetups' => Job::WORK_SETUPS,
        ]);
    }

    public function show(Job $job, Request $request): View
    {
        $this->authorize('view', $job);

        $user = $request->user();
        $jobView = $user->jobViews()->firstOrNew(['job_id' => $job->id]);

        if (! $jobView->exists) {
            $jobView->first_viewed_at = now();
        }

        $jobView->last_viewed_at = now();
        $jobView->save();

        $existingApplication = $user
            ->applications()
            ->where('job_id', $job->id)
            ->first();

        $resumes = $user->resumes()
            ->latest()
            ->get(['id', 'original_name', 'created_at']);

        $requiredSkills = collect($job->required_skills ?? [])
            ->map(static fn (mixed $skill): string => trim((string) $skill))
            ->filter()
            ->values();

        $userSkills = collect($user->skills ?? [])
            ->map(static fn (mixed $skill): string => Str::lower(trim((string) $skill)))
            ->filter()
            ->values();

        $matchedSkills = $requiredSkills->filter(
            static fn (string $skill): bool => $userSkills->contains(Str::lower($skill))
        )->values();

        $missingSkills = $requiredSkills->reject(
            static fn (string $skill): bool => $userSkills->contains(Str::lower($skill))
        )->values();

        $skillMatch = [
            'required_count' => $requiredSkills->count(),
            'matched' => $matchedSkills->all(),
            'missing' => $missingSkills->all(),
            'match_percent' => $requiredSkills->isNotEmpty()
                ? (int) round(($matchedSkills->count() / $requiredSkills->count()) * 100)
                : null,
        ];

        return view('dashboards.job-seeker.jobs.show', [
            'job' => $job->load(['employer:id,first_name,last_name,email', 'employer.employerProfile']),
            'existingApplication' => $existingApplication,
            'resumes' => $resumes,
            'skillMatch' => $skillMatch,
        ]);
    }
}
