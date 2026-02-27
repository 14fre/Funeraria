<?php

namespace App\Http\Livewire\Profile;

use App\Constants\Roles;
use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm as JetstreamUpdateProfileInformationForm;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateProfileInformationForm extends JetstreamUpdateProfileInformationForm
{
    /**
     * Redirigir al perfil del cliente si es cliente, sino al perfil estándar.
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            if (!$user->relationLoaded('role')) {
                $user->load('role');
            }
            return $user->hasRole(Roles::CLIENTE)
                ? redirect()->route('cliente.perfil')
                : redirect()->route('profile.show');
        }

        $this->dispatch('saved');
        $this->dispatch('refresh-navigation-menu');
    }
}
