<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $fillable = ['nombre', 'apellido', 'email', 'password', 'rol_id', 'activo'];
    protected $hidden = ['password'];

    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class, 'usuario_id');
    }
}

