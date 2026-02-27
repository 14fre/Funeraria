<?php

namespace App\Livewire\Admin\Inventario;

use App\Models\Inventario;
use App\Services\InventarioService;
use Livewire\Component;

class Edit extends Component
{
    public Inventario $item;
    public $nombre = '';
    public $tipo = 'otros';
    public $marca = '';
    public $material = '';
    public $proveedor = '';
    public $stock_actual = 0;
    public $stock_minimo = 0;
    public $precio_compra = 0;
    public $precio_venta = 0;
    public $estado = 'disponible';
    public $fecha_ingreso = '';
    public $descripcion = '';

    public function mount(Inventario $inventario)
    {
        $this->item = $inventario;
        $this->nombre = $inventario->nombre;
        $this->tipo = $inventario->tipo;
        $this->marca = $inventario->marca ?? '';
        $this->material = $inventario->material ?? '';
        $this->proveedor = $inventario->proveedor ?? '';
        $this->stock_actual = $inventario->stock_actual;
        $this->stock_minimo = $inventario->stock_minimo;
        $this->precio_compra = $inventario->precio_compra;
        $this->precio_venta = $inventario->precio_venta;
        $this->estado = $inventario->estado;
        $this->fecha_ingreso = $inventario->fecha_ingreso?->toDateString() ?? '';
        $this->descripcion = $inventario->descripcion ?? '';
    }

    protected function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'tipo' => ['required', 'in:urna,ataud,flores,velas,otros'],
            'marca' => ['nullable', 'string', 'max:100'],
            'material' => ['nullable', 'string', 'max:100'],
            'proveedor' => ['nullable', 'string', 'max:255'],
            'stock_actual' => ['required', 'integer', 'min:0'],
            'stock_minimo' => ['required', 'integer', 'min:0'],
            'precio_compra' => ['nullable', 'numeric', 'min:0'],
            'precio_venta' => ['nullable', 'numeric', 'min:0'],
            'estado' => ['required', 'in:disponible,agotado,discontinuado'],
            'fecha_ingreso' => ['nullable', 'date'],
            'descripcion' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function save(InventarioService $service)
    {
        $this->authorize('update', $this->item);
        $this->validate();
        $service->update($this->item, [
            'nombre' => $this->nombre,
            'tipo' => $this->tipo,
            'marca' => $this->marca ?: null,
            'material' => $this->material ?: null,
            'proveedor' => $this->proveedor ?: null,
            'stock_actual' => $this->stock_actual,
            'stock_minimo' => $this->stock_minimo,
            'precio_compra' => $this->precio_compra ?: 0,
            'precio_venta' => $this->precio_venta ?: 0,
            'estado' => $this->estado,
            'fecha_ingreso' => $this->fecha_ingreso ?: null,
            'descripcion' => $this->descripcion ?: null,
        ]);
        session()->flash('success', 'Ítem actualizado correctamente.');
        return $this->redirect(route('admin.inventario.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.inventario.edit');
    }
}
