<?php

namespace App\Policies;

use App\Models\Beneficiario;
use App\Models\User;
use App\Constants\Roles;

class BeneficiarioPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Admin ve todos; cliente verá filtrado por su afiliado en el componente
    }

    public function view(User $user, Beneficiario $beneficiario): bool
    {
        if ($user->hasRole(Roles::ADMIN)) {
            return true;
        }
        $afiliado = $user->afiliado;
        return $afiliado && (int) $beneficiario->afiliado_id === (int) $afiliado->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Beneficiario $beneficiario): bool
    {
        return $this->view($user, $beneficiario);
    }

    public function delete(User $user, Beneficiario $beneficiario): bool
    {
        return $this->view($user, $beneficiario);
    }
}
