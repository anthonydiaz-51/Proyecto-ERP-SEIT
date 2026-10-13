<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios';
    public $timestamps = false;

    protected $fillable = [
        'categoria_id', 'servicio', 'descripcion',
        'precio_base', 'tipo_precio', 'activo', 'promocion',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaServicio::class, 'categoria_id');
    }
}