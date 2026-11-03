<?php

namespace Database\Seeders;

use App\Models\CategoriaServicio;
use Illuminate\Database\Seeder;

class CategoriaServicioSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Soporte técnico',
            'Redes / Cableado estructurado',
            'Sistemas de seguridad',
            'Diseño web / Hosting / Dominios',
            'Venta equipo',
            'Educación',
            'Publicidad',
        ] as $nombre) {
            CategoriaServicio::query()->firstOrCreate(['nombre' => $nombre], ['activo' => true]);
        }
    }
}
