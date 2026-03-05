<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;

class JobPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isEmployer() || $user->isJobSeeker() || $user->isAdmin();
    }

    public function view(User $user, Job $job): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isEmployer()) {
            return $job->employer_id === $user->id;
        }

        if ($user->isJobSeeker()) {
            return $job->status === Job::STATUS_PUBLISHED
                || $job->applications()->where('job_seeker_id', $user->id)->exists();
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->isEmployer();
    }

    public function update(User $user, Job $job): bool
    {
        return $user->isAdmin() || ($user->isEmployer() && $job->employer_id === $user->id);
    }

    public function delete(User $user, Job $job): bool
    {
        return $user->isAdmin() || ($user->isEmployer() && $job->employer_id === $user->id);
    }

    public function manageApplicants(User $user, Job $job): bool
    {
        return $user->isAdmin() || ($user->isEmployer() && $job->employer_id === $user->id);
    }

    public function apply(User $user, Job $job): bool
    {
        return $user->isJobSeeker() && $job->status === Job::STATUS_PUBLISHED;
    }
}

