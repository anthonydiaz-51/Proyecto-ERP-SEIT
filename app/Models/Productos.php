<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';

    public $timestamps = false;

    protected $fillable = [
        'categoria_id',
        'codigo',
        'nombre',
        'descripcion',
        'precio_compra',
        'precio_venta',
        'stock_minimo',
        'activo',
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'stock_minimo' => 'integer',
        'activo' => 'boolean',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaProducto::class, 'categoria_id');
    }

    public function inventario()
    {
        return $this->hasOne(Inventario::class, 'producto_id');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class, 'producto_id');
    }
}
