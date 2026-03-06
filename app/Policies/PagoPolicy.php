<?php

namespace App\Policies;

use App\Models\Pago;
use App\Models\User;
use App\Constants\Roles;

class PagoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, Pago $pago): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, Pago $pago): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, Pago $pago): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
