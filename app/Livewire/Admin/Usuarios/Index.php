<?php

namespace App\Livewire\Admin\Usuarios;

use App\Models\User;
use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $perPage = 10;
    public $sortField = 'name';
    public $sortDirection = 'asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'roleFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function delete($userId)
    {
        $user = User::findOrFail($userId);
        
        // No permitir eliminar el usuario actual
        if ($user->id === auth()->id()) {
            session()->flash('error', 'No puedes eliminar tu propio usuario.');
            return;
        }

        $user->delete();
        session()->flash('success', 'Usuario eliminado correctamente.');
    }

    public function render()
    {
        $query = User::with('role')
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($q) {
                $q->whereHas('role', function ($query) {
                    $query->where('nombre', $this->roleFilter);
                });
            });

        $users = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $roles = Role::all();

        return view('livewire.admin.usuarios.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}

