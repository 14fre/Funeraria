<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        // Usar updateOrCreate para evitar duplicados
        Role::updateOrCreate(
            ['id' => 1],
            ['nombre' => 'admin']
        );

        Role::updateOrCreate(
            ['id' => 2],
            ['nombre' => 'cliente']
        );
    }
}
