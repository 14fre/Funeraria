<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventario extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventario';

    protected $fillable = [
        'nombre',
        'tipo',
        'marca',
        'material',
        'proveedor',
        'stock_actual',
        'stock_minimo',
        'precio_compra',
        'precio_venta',
        'estado',
        'fecha_ingreso',
        'descripcion',
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'fecha_ingreso' => 'date',
    ];

    // Scopes
    public function scopeDisponibles($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function scopeBajoStock($query)
    {
        return $query->whereColumn('stock_actual', '<=', 'stock_minimo');
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }
}

