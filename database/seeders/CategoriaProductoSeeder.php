<?php

namespace Database\Seeders;

use App\Models\CategoriaProducto;
use Illuminate\Database\Seeder;

class CategoriaProductoSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            'Componentes',
            'Cables',
            'Consumibles',
            'Accesorios',
            'Equipo de computo',
            'CCTV',
            'Redes',
            'Papelería',
        ] as $nombre) {
            CategoriaProducto::query()->firstOrCreate(['nombre' => $nombre], ['activo' => true]);
        }
    }
}
