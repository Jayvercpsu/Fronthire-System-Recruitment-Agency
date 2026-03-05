<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class ApplicationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isEmployer() || $user->isJobSeeker() || $user->isAdmin();
    }

    public function view(User $user, Application $application): bool
    {
        return $user->isAdmin()
            || $application->job_seeker_id === $user->id
            || $application->job->employer_id === $user->id;
    }

    public function create(User $user, Job $job): bool
    {
        return $user->isJobSeeker() && $job->status === Job::STATUS_PUBLISHED;
    }

    public function updateStatus(User $user, Application $application): bool
    {
        return $user->isAdmin() || ($user->isEmployer() && $application->job->employer_id === $user->id);
    }
}

