<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $role_id = 2; // Por defecto cliente

    protected function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
        ];
    }

    public function save()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role_id' => $this->role_id,
        ]);

        session()->flash('success', 'Usuario creado correctamente.');
        return redirect()->route('admin.usuarios.index');
    }

    public function render()
    {
        $roles = Role::all();
        
        return view('livewire.admin.usuarios.create', [
            'roles' => $roles,
        ]);
    }
}

