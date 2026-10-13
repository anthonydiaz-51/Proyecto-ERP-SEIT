<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaServicio extends Model
{
    protected $table = 'categorias_servicio';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion', 'activo'];
}