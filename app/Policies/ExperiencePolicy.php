<?php

namespace App\Policies;

use App\Models\Experience;
use App\Models\User;

class ExperiencePolicy
{
    public function update(User $user, Experience $experience): bool
    {
        return $user->isAdmin() || $experience->user_id === $user->id;
    }

    public function delete(User $user, Experience $experience): bool
    {
        return $user->isAdmin() || $experience->user_id === $user->id;
    }
}

