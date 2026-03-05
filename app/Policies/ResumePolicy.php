<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Resume;
use App\Models\User;

class ResumePolicy
{
    public function view(User $user, Resume $resume): bool
    {
        if ($user->isAdmin()) {
            return true;
        }

        if ($user->isJobSeeker()) {
            return $resume->user_id === $user->id;
        }

        if (! $user->isEmployer()) {
            return false;
        }

        return Application::query()
            ->where(function ($query) use ($resume): void {
                $query->where('resume_id', $resume->id)
                    ->orWhere('job_seeker_id', $resume->user_id);
            })
            ->whereHas('job', function ($jobQuery) use ($user): void {
                $jobQuery->where('employer_id', $user->id);
            })
            ->exists();
    }

    public function delete(User $user, Resume $resume): bool
    {
        return $user->isAdmin() || ($user->isJobSeeker() && $resume->user_id === $user->id);
    }
}
