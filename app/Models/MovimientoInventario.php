<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    protected $table = 'movimientos_inventario';

    public $timestamps = false;

    protected $fillable = [
        'producto_id',
        'tipo',
        'cantidad',
        'referencia',
        'motivo',
        'usuario_id',
    ];

    protected $casts = [
        'cantidad' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}
