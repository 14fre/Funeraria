<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'afiliado_id',
        'tipo_documento',
        'numero_documento',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'genero',
        'telefono',
        'email',
        'parentesco',
        'direccion',
        'ciudad',
        'departamento',
        'activo',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    // Relaciones
    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function servicios()
    {
        return $this->hasMany(ServicioFunerario::class);
    }

    // Accessors
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombres} {$this->apellidos}";
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}

