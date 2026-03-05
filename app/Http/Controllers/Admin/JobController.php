<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ModerateJobRequest;
use App\Models\Job;
use Carbon\CarbonImmutable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    public function index(Request $request): View
    {
        $query = Job::query()
            ->with(['employer:id,first_name,last_name,email'])
            ->withCount('applications')
            ->latest();

        if ($request->filled('status') && in_array($request->string('status')->toString(), Job::STATUSES, true)) {
            $query->where('status', $request->string('status')->toString());
        }

        if ($request->filled('search')) {
            $search = $request->string('search')->toString();
            $query->where(function ($searchQuery) use ($search): void {
                $searchQuery->where('title', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhereHas('employer', function ($employerQuery) use ($search): void {
                        $employerQuery->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        return view('admin.jobs.index', [
            'jobs' => $query->paginate(15)->withQueryString(),
            'statuses' => Job::STATUSES,
        ]);
    }

    public function updateStatus(ModerateJobRequest $request, Job $job): RedirectResponse
    {
        $status = $request->string('status')->toString();
        $job->status = $status;

        $now = CarbonImmutable::now();

        if ($status === Job::STATUS_PUBLISHED && ! $job->published_at) {
            $job->published_at = $now;
        }

        if ($status === Job::STATUS_CLOSED) {
            $job->closed_at = $now;
        } else {
            $job->closed_at = null;
        }

        $job->save();

        return back()->with('success', 'Job status updated.');
    }

    public function destroy(Job $job): RedirectResponse
    {
        $job->delete();

        return back()->with('success', 'Job removed.');
    }
}

