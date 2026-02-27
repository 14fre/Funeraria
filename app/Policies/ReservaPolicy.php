<?php

namespace App\Policies;

use App\Models\Reserva;
use App\Models\User;
use App\Constants\Roles;

class ReservaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, Reserva $reserva): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, Reserva $reserva): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function delete(User $user, Reserva $reserva): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, Reserva $reserva): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, Reserva $reserva): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
