<?php

namespace App\Policies;

use App\Models\ServicioFunerario;
use App\Models\User;
use App\Constants\Roles;

class ServicioFunerarioPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, ServicioFunerario $servicio): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }
        $afiliado = $user->afiliado;
        return $afiliado && (int) $servicio->afiliado_id === (int) $afiliado->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, ServicioFunerario $servicio): bool
    {
        return $this->view($user, $servicio);
    }

    public function delete(User $user, ServicioFunerario $servicio): bool
    {
        return $user->hasRole(Roles::ADMIN) || $this->view($user, $servicio);
    }
}
