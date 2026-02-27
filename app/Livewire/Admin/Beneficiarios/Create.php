<?php

namespace App\Livewire\Admin\Beneficiarios;

use App\Models\Beneficiario;
use App\Services\AfiliadoService;
use App\Services\BeneficiarioService;
use Livewire\Component;

class Create extends Component
{
    public $afiliado_id = '';
    public $tipo_documento = 'CC';
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

    protected function rules(): array
    {
        return [
            'afiliado_id' => ['required', 'exists:afiliados,id'],
            'tipo_documento' => ['required', 'in:CC,CE,TI,PASAPORTE'],
            'numero_documento' => ['required', 'string', 'max:20'],
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

    public function save(BeneficiarioService $service, AfiliadoService $afiliadoService)
    {
        $this->authorize('create', Beneficiario::class);
        $this->validate();
        try {
            $service->create([
                'afiliado_id' => $this->afiliado_id,
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
            session()->flash('success', 'Beneficiario creado correctamente.');
            return redirect()->route('admin.beneficiarios.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->addError('afiliado_id', $e->validator->errors()->first('afiliado_id'));
        }
    }

    public function render(AfiliadoService $afiliadoService)
    {
        $this->authorize('create', Beneficiario::class);
        $afiliadosList = $afiliadoService->listPaginated([], 'numero_afiliacion', 'asc', 500);
        return view('livewire.admin.beneficiarios.create', ['afiliadosList' => $afiliadosList]);
    }
}
