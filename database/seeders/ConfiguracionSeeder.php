<?php

namespace Database\Seeders;

use App\Models\Configuracion;
use Illuminate\Database\Seeder;

class ConfiguracionSeeder extends Seeder
{
    public function run(): void
    {
        $configuraciones = [
            // Configuración General
            [
                'clave' => 'nombre_empresa',
                'valor' => 'Funeraria San José del Huila S.A.S.',
                'tipo' => 'text',
                'descripcion' => 'Nombre de la empresa',
                'grupo' => 'general',
            ],
            [
                'clave' => 'nit',
                'valor' => '',
                'tipo' => 'text',
                'descripcion' => 'NIT de la empresa',
                'grupo' => 'general',
            ],
            [
                'clave' => 'direccion',
                'valor' => '',
                'tipo' => 'text',
                'descripcion' => 'Dirección de la empresa',
                'grupo' => 'general',
            ],
            [
                'clave' => 'telefono',
                'valor' => '(608) 871-2345',
                'tipo' => 'text',
                'descripcion' => 'Teléfono de contacto',
                'grupo' => 'general',
            ],
            [
                'clave' => 'email',
                'valor' => 'info@funerariasanjose.co',
                'tipo' => 'text',
                'descripcion' => 'Email de contacto',
                'grupo' => 'general',
            ],
            [
                'clave' => 'sitio_web',
                'valor' => 'https://funerariasanjose.co',
                'tipo' => 'text',
                'descripcion' => 'Sitio web',
                'grupo' => 'general',
            ],
            [
                'clave' => 'dias_mora',
                'valor' => '30',
                'tipo' => 'integer',
                'descripcion' => 'Días de gracia antes de entrar en mora',
                'grupo' => 'general',
            ],
            [
                'clave' => 'stock_minimo_alert',
                'valor' => 'true',
                'tipo' => 'boolean',
                'descripcion' => 'Activar alertas de stock mínimo',
                'grupo' => 'inventario',
            ],
        ];

        foreach ($configuraciones as $config) {
            Configuracion::updateOrCreate(
                ['clave' => $config['clave']],
                $config
            );
        }
    }
}

