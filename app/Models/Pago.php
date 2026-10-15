<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    public $timestamps = false;

    protected $fillable = [
        'orden_id', 'fecha', 'monto', 'metodo_pago',
        'referencia', 'observaciones', 'usuario_id',
    ];

    public function orden()
    {
        return $this->belongsTo(OrdenServicio::class, 'orden_id');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id');
    }
}