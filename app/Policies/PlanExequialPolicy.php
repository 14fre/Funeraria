<?php

namespace App\Policies;

use App\Models\PlanExequial;
use App\Models\User;
use App\Constants\Roles;

class PlanExequialPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, PlanExequial $plan): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, PlanExequial $plan): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, PlanExequial $plan): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, PlanExequial $plan): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, PlanExequial $plan): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
