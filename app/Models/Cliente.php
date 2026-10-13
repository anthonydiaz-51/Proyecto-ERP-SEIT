<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'tipo_cliente',
        'nombre',
        'razon_social',
        'rfc',
        'telefono',
        'email',
        'notas',
        'activo',
    ];
}