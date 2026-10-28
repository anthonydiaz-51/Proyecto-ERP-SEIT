<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';

    protected $fillable = [
        'tipo_proveedor',
        'nombre',
        'razon_social',
        'rfc',
        'contacto',
        'telefono',
        'email',
        'sitio_web',
        'calle',
        'numero_exterior',
        'numero_interior',
        'colonia',
        'municipio',
        'estado',
        'codigo_postal',
        'notas',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function compras()
    {
        return $this->hasMany(Compra::class, 'proveedor_id');
    }
}
