<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            1 => ['nombre' => 'Administrador', 'descripcion' => 'Administración del sistema'],
            2 => ['nombre' => 'Gerencia', 'descripcion' => 'Supervisión de la operación'],
            3 => ['nombre' => 'Ventas', 'descripcion' => 'Gestión comercial'],
            4 => ['nombre' => 'Técnico', 'descripcion' => 'Atención de órdenes de servicio'],
            5 => ['nombre' => 'Practicante', 'descripcion' => 'Acceso operativo limitado'],
        ] as $id => $datos) {
            Roles::query()->firstOrCreate(['id' => $id], $datos + ['activo' => true]);
        }
    }
}
