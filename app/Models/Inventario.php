<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    protected $table = 'inventario';

    public $timestamps = false;

    protected $fillable = ['producto_id', 'existencia', 'ubicacion', 'updated_at'];

    protected $casts = [
        'existencia' => 'decimal:2',
        'updated_at' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
