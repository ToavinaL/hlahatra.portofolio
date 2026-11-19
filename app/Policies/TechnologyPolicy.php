<?php

namespace App\Policies;

use App\Models\Technology;
use App\Models\User;

class TechnologyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->is_admin === true;
    }

    public function view(User $user, Technology $technology): bool
    {
        return $user->is_admin === true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin === true;
    }

    public function update(User $user, Technology $technology): bool
    {
        return $user->is_admin === true;
    }

    public function delete(User $user, Technology $technology): bool
    {
        return $user->is_admin === true;
    }
}
