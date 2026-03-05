<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;

class EducationPolicy
{
    public function update(User $user, Education $education): bool
    {
        return $user->isAdmin() || $education->user_id === $user->id;
    }

    public function delete(User $user, Education $education): bool
    {
        return $user->isAdmin() || $education->user_id === $user->id;
    }
}

