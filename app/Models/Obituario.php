<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Obituario extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'servicio_funerario_id',
        'numero_documento',
        'nombre_completo',
        'fecha_nacimiento',
        'fecha_fallecimiento',
        'lugar_fallecimiento',
        'biografia',
        'mensaje_familia',
        'foto',
        'fecha_velacion',
        'lugar_velacion',
        'fecha_sepultura',
        'lugar_sepultura',
        'publicado',
        'visitas',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'fecha_fallecimiento' => 'date',
        'fecha_velacion' => 'date',
        'fecha_sepultura' => 'date',
        'publicado' => 'boolean',
    ];

    // Relaciones
    public function servicioFunerario()
    {
        return $this->belongsTo(ServicioFunerario::class);
    }

    public function condolencias()
    {
        return $this->hasMany(Condolencia::class);
    }

    public function condolenciasAprobadas()
    {
        return $this->hasMany(Condolencia::class)->where('aprobado', true);
    }

    // Scopes
    public function scopePublicados($query)
    {
        return $query->where('publicado', true);
    }
}

