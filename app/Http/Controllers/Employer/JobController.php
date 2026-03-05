<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employer\StoreJobRequest;
use App\Http\Requests\Employer\UpdateJobRequest;
use App\Models\Job;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::query()
            ->where('employer_id', $request->user()->id)
            ->withCount('applications')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();

            $query->where(function ($searchQuery) use ($search): void {
                $searchQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && in_array($request->string('status')->toString(), Job::STATUSES, true)) {
            $query->where('status', $request->string('status')->toString());
        }

        $jobs = $query->paginate(10)->withQueryString();

        return view('dashboards.employer.jobs.index', [
            'jobs' => $jobs,
            'statuses' => Job::STATUSES,
        ]);
    }

    public function create(): View
    {
        return view('dashboards.employer.jobs.create', [
            'job' => new Job(),
            'statuses' => Job::STATUSES,
            'jobTypes' => Job::JOB_TYPES,
            'workSetups' => Job::WORK_SETUPS,
        ]);
    }

    public function store(StoreJobRequest $request): RedirectResponse
    {
        $payload = $request->validated();
        $payload['required_skills'] = $this->parseRequiredSkills($request->input('required_skills'));

        $job = new Job($payload);
        $job->employer_id = $request->user()->id;

        $this->syncStatusTimestamps($job, null, $job->status);
        $job->save();

        return redirect()->route('employer.jobs.index')->with('success', 'Job posted successfully.');
    }

    public function edit(Job $job): View
    {
        $this->authorize('update', $job);

        return view('dashboards.employer.jobs.edit', [
            'job' => $job,
            'statuses' => Job::STATUSES,
            'jobTypes' => Job::JOB_TYPES,
            'workSetups' => Job::WORK_SETUPS,
        ]);
    }

    public function update(UpdateJobRequest $request, Job $job): RedirectResponse
    {
        $this->authorize('update', $job);

        $originalStatus = $job->status;

        $payload = $request->validated();
        $payload['required_skills'] = $this->parseRequiredSkills($request->input('required_skills'));

        $job->fill($payload);
        $this->syncStatusTimestamps($job, $originalStatus, $job->status);
        $job->save();

        return redirect()->route('employer.jobs.index')->with('success', 'Job updated successfully.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $this->authorize('delete', $job);

        $job->delete();

        return redirect()->route('employer.jobs.index')->with('success', 'Job deleted.');
    }

    private function syncStatusTimestamps(Job $job, ?string $previousStatus, string $currentStatus): void
    {
        $now = CarbonImmutable::now();

        if ($currentStatus === Job::STATUS_PUBLISHED && ! $job->published_at) {
            $job->published_at = $now;
        }

        if ($currentStatus === Job::STATUS_CLOSED && ! $job->closed_at) {
            $job->closed_at = $now;
        }

        if ($currentStatus !== Job::STATUS_CLOSED) {
            $job->closed_at = null;
        }

        if ($currentStatus !== Job::STATUS_PUBLISHED && $previousStatus !== null && $previousStatus === Job::STATUS_DRAFT) {
            $job->published_at = null;
        }
    }

    private function parseRequiredSkills(mixed $value): array
    {
        if (! is_string($value) || trim($value) === '') {
            return [];
        }

        return Collection::make(preg_split('/[\r\n,;]+/', $value))
            ->map(static fn (mixed $skill): string => Str::of((string) $skill)->squish()->toString())
            ->filter()
            ->unique(static fn (string $skill): string => Str::lower($skill))
            ->take(30)
            ->values()
            ->all();
    }
}
