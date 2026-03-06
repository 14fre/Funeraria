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
            if ($user->hasRole(Roles::CLIENTE)) {
                return redirect()->route('cliente.perfil');
            }
            if ($user->hasRole(Roles::ADMIN)) {
                return redirect()->route('admin.perfil');
            }
            return redirect()->route('profile.show');
        }

        $this->dispatch('saved');
        $this->dispatch('refresh-navigation-menu');
    }
}
