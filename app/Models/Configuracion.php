<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuracion';

    protected $fillable = [
        'clave',
        'valor',
        'tipo',
        'descripcion',
        'grupo',
    ];

    // Métodos estáticos para obtener configuración
    public static function obtener($clave, $default = null)
    {
        $config = self::where('clave', $clave)->first();
        return $config ? self::castValue($config->valor, $config->tipo) : $default;
    }

    public static function establecer($clave, $valor, $tipo = 'text', $descripcion = null, $grupo = null)
    {
        return self::updateOrCreate(
            ['clave' => $clave],
            [
                'valor' => $valor,
                'tipo' => $tipo,
                'descripcion' => $descripcion,
                'grupo' => $grupo,
            ]
        );
    }

    protected static function castValue($valor, $tipo)
    {
        return match ($tipo) {
            'boolean' => (bool) $valor,
            'number', 'integer' => (int) $valor,
            'float' => (float) $valor,
            'json' => json_decode($valor, true),
            default => $valor,
        };
    }
}

