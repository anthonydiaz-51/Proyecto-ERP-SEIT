<?php

namespace App\Http\Controllers;

use App\Models\OrdenServicio;
use App\Models\OrdenServicioDetalle;
use App\Models\Cliente;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Cotizacion;

class OrdenServicioController extends Controller
{
    protected function subtotalLinea(array $linea): float
    {
        return ($linea['cantidad'] * $linea['precio_unitario']) - ($linea['descuento'] ?? 0);
    }

    protected function calcularCostoTotal(array $lineas): float
    {
        $total = 0;
        foreach ($lineas as $linea) {
            $total += $this->subtotalLinea($linea);
        }
        return $total;
    }

    protected function generarFolio(): string
    {
        $consecutivo = OrdenServicio::count() + 1;
        return 'OS-' . date('Y') . '-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);
    }

    protected function reglasLineas(): array
    {
        return [
            'lineas' => 'nullable|array',
            'lineas.*.servicio_id' => 'required_with:lineas|exists:servicios,id',
            'lineas.*.cantidad' => 'required_with:lineas|numeric|min:0.01',
            'lineas.*.precio_unitario' => 'required_with:lineas|numeric|min:0',
            'lineas.*.descuento' => 'nullable|numeric|min:0',
        ];
    }

    public function index()
    {
        $ordenes = OrdenServicio::with(['cliente', 'tecnico'])->orderByDesc('id')->paginate(15);

        return view('sistemas.ordenes-servicio.index', compact('ordenes'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $servicios = Servicio::where('activo', true)->orderBy('servicio')->get();
        $tecnicos = Usuario::where('rol_id', 4)->where('activo', true)->get(); // rol_id 4 = Técnico

        return view('sistemas.ordenes-servicio.create', compact('clientes', 'servicios', 'tecnicos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(array_merge([
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'nullable|exists:usuarios,id',
            'fecha_recepcion' => 'required|date',
            'fecha_compromiso' => 'nullable|date',
            'prioridad' => 'nullable|string|max:20',
            'descripcion_falla' => 'nullable|string',
        ], $this->reglasLineas()));

        $lineas = $validated['lineas'] ?? [];
        $costoTotal = $this->calcularCostoTotal($lineas);

        DB::transaction(function () use ($validated, $lineas, $costoTotal) {
            $orden = OrdenServicio::create([
                'folio' => $this->generarFolio(),
                'cliente_id' => $validated['cliente_id'],
                'tecnico_id' => $validated['tecnico_id'] ?? null,
                'usuario_registro_id' => Auth::id(),
                'fecha_recepcion' => $validated['fecha_recepcion'],
                'fecha_compromiso' => $validated['fecha_compromiso'] ?? null,
                'estado' => 'RECIBIDO',
                'prioridad' => $validated['prioridad'] ?? 'MEDIA',
                'descripcion_falla' => $validated['descripcion_falla'] ?? null,
                'costo_total' => $costoTotal,
            ]);

            foreach ($lineas as $linea) {
                OrdenServicioDetalle::create([
                    'orden_id' => $orden->id,
                    'servicio_id' => $linea['servicio_id'],
                    'cantidad' => $linea['cantidad'],
                    'precio_unitario' => $linea['precio_unitario'],
                    'descuento' => $linea['descuento'] ?? 0,
                    'subtotal' => $this->subtotalLinea($linea),
                ]);
            }
        });

        return redirect()
            ->route('sistemas.ordenes.index')
            ->with('success', 'Orden de servicio creada correctamente.');
    }

    public function edit(string $id)
    {
        $orden = OrdenServicio::with('detalles')->findOrFail($id);
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $servicios = Servicio::where('activo', true)->orderBy('servicio')->get();
        $tecnicos = Usuario::where('rol_id', 4)->where('activo', true)->get();

        return view('sistemas.ordenes-servicio.edit', compact('orden', 'clientes', 'servicios', 'tecnicos'));
    }

    public function update(Request $request, string $id)
    {
        $orden = OrdenServicio::findOrFail($id);

        $validated = $request->validate(array_merge([
            'cliente_id' => 'required|exists:clientes,id',
            'tecnico_id' => 'nullable|exists:usuarios,id',
            'fecha_recepcion' => 'required|date',
            'fecha_compromiso' => 'nullable|date',
            'fecha_entrega' => 'nullable|date',
            'estado' => 'required|in:RECIBIDO,DIAGNOSTICO,COTIZACION,AUTORIZADO,EN_PROCESO,LISTO,ENTREGADO,CANCELADO',
            'prioridad' => 'nullable|string|max:20',
            'descripcion_falla' => 'nullable|string',
            'diagnostico' => 'nullable|string',
            'solucion' => 'nullable|string',
            'observaciones' => 'nullable|string',
        ], $this->reglasLineas()));

        $lineas = $validated['lineas'] ?? [];
        $costoTotal = $this->calcularCostoTotal($lineas);

        // Si la orden se marca como ENTREGADO y no se capturó fecha de entrega, se usa la fecha del día
        $fechaEntrega = $validated['fecha_entrega'] ?? null;
        if ($validated['estado'] === 'ENTREGADO' && empty($fechaEntrega)) {
            $fechaEntrega = now()->toDateString();
        }

        DB::transaction(function () use ($orden, $validated, $lineas, $costoTotal, $fechaEntrega) {
            $orden->update([
                'cliente_id' => $validated['cliente_id'],
                'tecnico_id' => $validated['tecnico_id'] ?? null,
                'fecha_recepcion' => $validated['fecha_recepcion'],
                'fecha_compromiso' => $validated['fecha_compromiso'] ?? null,
                'fecha_entrega' => $fechaEntrega,
                'estado' => $validated['estado'],
                'prioridad' => $validated['prioridad'] ?? null,
                'descripcion_falla' => $validated['descripcion_falla'] ?? null,
                'diagnostico' => $validated['diagnostico'] ?? null,
                'solucion' => $validated['solucion'] ?? null,
                'observaciones' => $validated['observaciones'] ?? null,
                'costo_total' => $costoTotal,
            ]);

            OrdenServicioDetalle::where('orden_id', $orden->id)->delete();

            foreach ($lineas as $linea) {
                OrdenServicioDetalle::create([
                    'orden_id' => $orden->id,
                    'servicio_id' => $linea['servicio_id'],
                    'cantidad' => $linea['cantidad'],
                    'precio_unitario' => $linea['precio_unitario'],
                    'descuento' => $linea['descuento'] ?? 0,
                    'subtotal' => $this->subtotalLinea($linea),
                ]);
            }
        });

        return redirect()
            ->route('sistemas.ordenes.index')
            ->with('success', 'Orden de servicio actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $orden = OrdenServicio::findOrFail($id);
        $orden->update(['estado' => 'CANCELADO']);

        return redirect()
            ->route('sistemas.ordenes.index')
            ->with('success', 'Orden de servicio cancelada correctamente.');
    }

    public function desdeCotizacion(string $id)
{
    $cotizacion = Cotizacion::with('detalles')->findOrFail($id);

    if ($cotizacion->estado !== 'ACEPTADA') {
        return back()->with('error', 'Solo se puede generar una orden desde una cotización ACEPTADA.');
    }

    $existente = OrdenServicio::where('cotizacion_id', $cotizacion->id)
        ->where('estado', '!=', 'CANCELADO')
        ->first();

    if ($existente) {
        return redirect()
            ->route('sistemas.ordenes.edit', $existente)
            ->with('success', 'Esta cotización ya tiene la orden ' . $existente->folio . '.');
    }

    $orden = DB::transaction(function () use ($cotizacion) {
        $lineas = $cotizacion->detalles->filter(fn ($d) => $d->servicio_id);

        $orden = OrdenServicio::create([
            'folio' => $this->generarFolio(),
            'cliente_id' => $cotizacion->cliente_id,
            'cotizacion_id' => $cotizacion->id,
            'usuario_registro_id' => Auth::id(),
            'fecha_recepcion' => now()->toDateString(),
            'estado' => 'RECIBIDO',
            'prioridad' => 'MEDIA',
            'observaciones' => 'Generada desde la cotización ' . $cotizacion->folio,
            'costo_total' => $lineas->sum('subtotal'),
        ]);

        foreach ($lineas as $linea) {
            OrdenServicioDetalle::create([
                'orden_id' => $orden->id,
                'servicio_id' => $linea->servicio_id,
                'cantidad' => $linea->cantidad,
                'precio_unitario' => $linea->precio_unitario,
                'descuento' => $linea->descuento,
                'subtotal' => $linea->subtotal,
            ]);
        }

        return $orden;
    });

    return redirect()
        ->route('sistemas.ordenes.edit', $orden)
        ->with('success', 'Orden ' . $orden->folio . ' generada desde la cotización ' . $cotizacion->folio . '.');
}
}