<?php

namespace App\Policies;

use App\Models\Afiliado;
use App\Models\User;
use App\Constants\Roles;

class AfiliadoPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function view(User $user, Afiliado $afiliado): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }
        return $user->hasRole(Roles::CLIENTE) && (int) $afiliado->user_id === (int) $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function update(User $user, Afiliado $afiliado): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }
        return $user->hasRole(Roles::CLIENTE) && (int) $afiliado->user_id === (int) $user->id;
    }

    public function delete(User $user, Afiliado $afiliado): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function restore(User $user, Afiliado $afiliado): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }

    public function forceDelete(User $user, Afiliado $afiliado): bool
    {
        return $user->hasRole(Roles::ADMIN);
    }
}
