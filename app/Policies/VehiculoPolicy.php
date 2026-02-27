<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehiculo;
use App\Constants\Roles;

class VehiculoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, Vehiculo $vehiculo): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, Vehiculo $vehiculo): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, Vehiculo $vehiculo): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, Vehiculo $vehiculo): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, Vehiculo $vehiculo): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
