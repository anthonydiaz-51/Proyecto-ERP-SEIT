<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
    protected $table = 'cotizacion_detalle';
    public $timestamps = false;

    protected $fillable = [
        'cotizacion_id', 'servicio_id', 'producto_id',
        'descripcion', 'cantidad', 'precio_unitario', 'descuento', 'subtotal',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'cotizacion_id');
    }
}
