<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenServicio extends Model
{
    protected $table = 'ordenes_servicio';

    protected $fillable = [
        'folio', 'cliente_id', 'tecnico_id', 'usuario_registro_id',
        'fecha_recepcion', 'fecha_compromiso', 'fecha_entrega',
        'estado', 'prioridad', 'descripcion_falla', 'diagnostico',
        'solucion', 'observaciones', 'costo_total',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function tecnico()
    {
        return $this->belongsTo(Usuario::class, 'tecnico_id');
    }

    public function usuarioRegistro()
    {
        return $this->belongsTo(Usuario::class, 'usuario_registro_id');
    }

    public function detalles()
    {
        return $this->hasMany(OrdenServicioDetalle::class, 'orden_id');
    }
}