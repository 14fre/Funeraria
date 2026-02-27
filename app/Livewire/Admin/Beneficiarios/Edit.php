<?php

namespace App\Livewire\Admin\Beneficiarios;

use App\Models\Beneficiario;
use App\Services\BeneficiarioService;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
{
    public Beneficiario $beneficiario;
    public $tipo_documento = '';
    public $numero_documento = '';
    public $nombres = '';
    public $apellidos = '';
    public $fecha_nacimiento = '';
    public $genero = '';
    public $telefono = '';
    public $email = '';
    public $parentesco = '';
    public $direccion = '';
    public $ciudad = '';
    public $departamento = '';
    public $activo = true;

    public function mount(Beneficiario $beneficiario)
    {
        $this->authorize('update', $beneficiario);
        $this->beneficiario = $beneficiario;
        $this->tipo_documento = $beneficiario->tipo_documento;
        $this->numero_documento = $beneficiario->numero_documento;
        $this->nombres = $beneficiario->nombres;
        $this->apellidos = $beneficiario->apellidos;
        $this->fecha_nacimiento = $beneficiario->fecha_nacimiento->toDateString();
        $this->genero = $beneficiario->genero ?? '';
        $this->telefono = $beneficiario->telefono ?? '';
        $this->email = $beneficiario->email ?? '';
        $this->parentesco = $beneficiario->parentesco;
        $this->direccion = $beneficiario->direccion ?? '';
        $this->ciudad = $beneficiario->ciudad ?? '';
        $this->departamento = $beneficiario->departamento ?? '';
        $this->activo = $beneficiario->activo;
    }

    protected function rules(): array
    {
        return [
            'tipo_documento' => ['required', 'in:CC,CE,TI,PASAPORTE'],
            'numero_documento' => ['required', 'string', 'max:20', Rule::unique('beneficiarios', 'numero_documento')->where('tipo_documento', $this->tipo_documento)->ignore($this->beneficiario->id)],
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'fecha_nacimiento' => ['required', 'date'],
            'genero' => ['nullable', 'in:M,F,Otro'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'parentesco' => ['required', 'string', 'max:50'],
            'direccion' => ['nullable', 'string', 'max:500'],
            'ciudad' => ['nullable', 'string', 'max:100'],
            'departamento' => ['nullable', 'string', 'max:100'],
            'activo' => ['boolean'],
        ];
    }

    public function update(BeneficiarioService $service)
    {
        $this->authorize('update', $this->beneficiario);
        $this->validate();
        $service->update($this->beneficiario, [
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'genero' => $this->genero ?: null,
            'telefono' => $this->telefono ?: null,
            'email' => $this->email ?: null,
            'parentesco' => $this->parentesco,
            'direccion' => $this->direccion ?: null,
            'ciudad' => $this->ciudad ?: null,
            'departamento' => $this->departamento ?: null,
            'activo' => $this->activo,
        ]);
        session()->flash('success', 'Beneficiario actualizado.');
        return redirect()->route('admin.beneficiarios.index');
    }

    public function render()
    {
        return view('livewire.admin.beneficiarios.edit');
    }
}
