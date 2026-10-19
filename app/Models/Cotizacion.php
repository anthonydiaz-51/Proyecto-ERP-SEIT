<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';
    public $timestamps = false;

    protected $fillable = [
        'folio', 'cliente_id', 'usuario_id', 'fecha', 'vigencia',
        'estado', 'subtotal', 'descuento', 'impuestos', 'total', 'observaciones',
    ];

    public function ordenes()
    {
        return $this->hasMany(OrdenServicio::class, 'cotizacion_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }

    public function detalles()
    {
        return $this->hasMany(CotizacionDetalle::class, 'cotizacion_id');
    }
}