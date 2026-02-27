<?php

namespace App\Livewire\Admin\Obituarios;

use App\Models\Obituario;
use App\Services\ObituarioService;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    public $servicio_funerario_id = '';
    public $numero_documento = '';
    public $nombre_completo = '';
    public $fecha_nacimiento = '';
    public $fecha_fallecimiento = '';
    public $lugar_fallecimiento = '';
    public $biografia = '';
    public $mensaje_familia = '';
    public $foto = null;
    public $fecha_velacion = '';
    public $lugar_velacion = '';
    public $fecha_sepultura = '';
    public $lugar_sepultura = '';
    public $publicado = false;

    protected function rules(): array
    {
        return [
            'nombre_completo' => ['required', 'string', 'max:255'],
            'numero_documento' => ['nullable', 'string', 'max:30'],
            'fecha_nacimiento' => ['nullable', 'date'],
            'fecha_fallecimiento' => ['required', 'date'],
            'lugar_fallecimiento' => ['nullable', 'string', 'max:255'],
            'biografia' => ['nullable', 'string', 'max:5000'],
            'mensaje_familia' => ['nullable', 'string', 'max:2000'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'fecha_velacion' => ['nullable', 'date'],
            'lugar_velacion' => ['nullable', 'string', 'max:255'],
            'fecha_sepultura' => ['nullable', 'date'],
            'lugar_sepultura' => ['nullable', 'string', 'max:255'],
            'publicado' => ['boolean'],
            'servicio_funerario_id' => ['nullable', 'exists:servicios_funerarios,id'],
        ];
    }

    public function save(ObituarioService $service)
    {
        $this->authorize('create', Obituario::class);
        $this->validate();
        $fotoPath = null;
        if ($this->foto) {
            $fotoPath = $this->foto->store('obituarios', 'public');
        }
        $service->create([
            'servicio_funerario_id' => $this->servicio_funerario_id ? (int) $this->servicio_funerario_id : null,
            'numero_documento' => $this->numero_documento ?: null,
            'nombre_completo' => $this->nombre_completo,
            'fecha_nacimiento' => $this->fecha_nacimiento ?: null,
            'fecha_fallecimiento' => $this->fecha_fallecimiento,
            'lugar_fallecimiento' => $this->lugar_fallecimiento ?: null,
            'biografia' => $this->biografia ?: null,
            'mensaje_familia' => $this->mensaje_familia ?: null,
            'foto' => $fotoPath,
            'fecha_velacion' => $this->fecha_velacion ?: null,
            'lugar_velacion' => $this->lugar_velacion ?: null,
            'fecha_sepultura' => $this->fecha_sepultura ?: null,
            'lugar_sepultura' => $this->lugar_sepultura ?: null,
            'publicado' => filter_var($this->publicado, FILTER_VALIDATE_BOOLEAN),
        ]);
        session()->flash('success', 'Obituario creado correctamente.');
        return $this->redirect(route('admin.obituarios.index'), navigate: true);
    }

    public function render()
    {
        $servicios = \App\Models\ServicioFunerario::query()->orderByDesc('id')->limit(500)->get(['id', 'tipo', 'fecha_solicitud']);
        return view('livewire.admin.obituarios.create', compact('servicios'));
    }
}
