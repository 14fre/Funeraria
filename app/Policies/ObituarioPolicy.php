<?php

namespace App\Policies;

use App\Models\Obituario;
use App\Models\User;
use App\Constants\Roles;

class ObituarioPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, Obituario $obituario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, Obituario $obituario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, Obituario $obituario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, Obituario $obituario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, Obituario $obituario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
