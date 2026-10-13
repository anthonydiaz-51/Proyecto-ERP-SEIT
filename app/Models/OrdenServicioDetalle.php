<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenServicioDetalle extends Model
{
    protected $table = 'orden_servicio_detalle';
    public $timestamps = false;

    protected $fillable = [
        'orden_id', 'servicio_id', 'cantidad',
        'precio_unitario', 'descuento', 'subtotal', 'observaciones',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function orden()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_id');
    }
}