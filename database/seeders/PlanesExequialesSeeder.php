<?php

namespace Database\Seeders;

use App\Models\PlanExequial;
use Illuminate\Database\Seeder;

class PlanesExequialesSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            [
                'nombre' => 'Plan Individual',
                'descripcion' => 'Cobertura para una persona. Ideal para protección personal.',
                'tipo' => 'individual',
                'max_beneficiarios' => 1,
                'precio_mensual' => 50000,
                'precio_anual' => 550000,
                'servicios_incluidos' => [
                    'velacion',
                    'traslado_nacional',
                    'urna_basica',
                ],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Familiar',
                'descripcion' => 'Cobertura para hasta 5 beneficiarios. Perfecto para familias.',
                'tipo' => 'familiar',
                'max_beneficiarios' => 5,
                'precio_mensual' => 80000,
                'precio_anual' => 880000,
                'servicios_incluidos' => [
                    'velacion',
                    'velacion_virtual',
                    'traslado_nacional',
                    'urna_premium',
                    'flores',
                ],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Empresarial',
                'descripcion' => 'Cobertura para hasta 50 beneficiarios. Ideal para empresas.',
                'tipo' => 'empresarial',
                'max_beneficiarios' => 50,
                'precio_mensual' => 200000,
                'precio_anual' => 2200000,
                'servicios_incluidos' => [
                    'velacion',
                    'velacion_virtual',
                    'traslado_nacional',
                    'traslado_internacional',
                    'cremacion',
                    'urna_premium',
                    'flores',
                    'velas',
                ],
                'activo' => true,
            ],
            [
                'nombre' => 'Plan Anticipado',
                'descripcion' => 'Pago único con beneficios extendidos. Cobertura de por vida.',
                'tipo' => 'anticipado',
                'max_beneficiarios' => 10,
                'precio_mensual' => 0,
                'precio_anual' => 5000000,
                'servicios_incluidos' => [
                    'velacion',
                    'velacion_virtual',
                    'traslado_nacional',
                    'traslado_internacional',
                    'cremacion',
                    'urna_premium',
                    'flores',
                    'velas',
                    'sala_vip',
                ],
                'activo' => true,
            ],
        ];

        foreach ($planes as $plan) {
            PlanExequial::updateOrCreate(
                ['nombre' => $plan['nombre']],
                $plan
            );
        }
    }
}

