<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MantenimientoVehiculo extends Model
{
    use HasFactory;

    protected $table = 'mantenimientos_vehiculos';

    protected $fillable = [
        'vehiculo_id',
        'fecha_mantenimiento',
        'tipo',
        'descripcion',
        'costo',
        'kilometraje',
        'taller',
        'observaciones',
    ];

    protected $casts = [
        'fecha_mantenimiento' => 'date',
        'costo' => 'decimal:2',
    ];

    // Relaciones
    public function vehiculo()
    {
        return $this->belongsTo(Vehiculo::class);
    }

    // Scopes
    public function scopeRecientes($query)
    {
        return $query->orderBy('fecha_mantenimiento', 'desc');
    }
}

