<?php

namespace App\Policies;

use App\Models\Inventario;
use App\Models\User;
use App\Constants\Roles;

class InventarioPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, Inventario $inventario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, Inventario $inventario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, Inventario $inventario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, Inventario $inventario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, Inventario $inventario): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
