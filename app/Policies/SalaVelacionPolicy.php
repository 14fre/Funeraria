<?php

namespace App\Policies;

use App\Models\SalaVelacion;
use App\Models\User;
use App\Constants\Roles;

class SalaVelacionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, SalaVelacion $sala): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, SalaVelacion $sala): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, SalaVelacion $sala): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, SalaVelacion $sala): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, SalaVelacion $sala): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
