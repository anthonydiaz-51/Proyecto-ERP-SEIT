<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\CotizacionDetalle;
use App\Models\Cliente;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CotizacionController extends Controller
{
    protected function montoDescuento(array $linea): float
    {
        $importeBruto = $linea['cantidad'] * $linea['precio_unitario'];
        $descuento = $linea['descuento'] ?? 0;

        return ($linea['tipo_descuento'] ?? 'FIJO') === 'PORCENTAJE'
            ? $importeBruto * $descuento / 100
            : $descuento;
    }

    protected function subtotalLinea(array $linea): float
    {
        $importeBruto = $linea['cantidad'] * $linea['precio_unitario'];

        return $importeBruto - $this->montoDescuento($linea);
    }

    protected function calcularTotales(array $lineas): array
    {
        $subtotal = 0;
        foreach ($lineas as $linea) {
            $subtotal += $this->subtotalLinea($linea);
        }
        $impuestos = round($subtotal * 0.16, 2); // IVA 16% — ajustar si SEIT define otra tasa
        $total = $subtotal + $impuestos;

        return compact('subtotal', 'impuestos', 'total');
    }

    protected function generarFolio(): string
    {
        $consecutivo = Cotizacion::count() + 1;
        return 'COT-' . date('Y') . '-' . str_pad($consecutivo, 3, '0', STR_PAD_LEFT);
    }

    protected function reglasLineas(): array
    {
        return [
            'lineas' => 'required|array|min:1',
            'lineas.*.servicio_id' => 'required|exists:servicios,id',
            'lineas.*.cantidad' => 'required|numeric|min:0.01',
            'lineas.*.precio_unitario' => 'required|numeric|min:0',
            'lineas.*.tipo_descuento' => 'nullable|in:FIJO,PORCENTAJE',
            'lineas.*.descuento' => 'nullable|numeric|min:0',
        ];
    }

    public function index(Request $request)
    {
        $validated = $request->validate([
            'folio' => 'nullable|string|max:50',
        ]);
        $folio = trim($validated['folio'] ?? '');

        $consultaBase = Cotizacion::with('cliente')
            ->when($folio !== '', fn ($query) => $query->where('folio', 'like', "%{$folio}%"))
            ;

        $cotizacionesActivas = (clone $consultaBase)
            ->whereIn('estado', ['PENDIENTE', 'ACEPTADA'])
            ->orderByDesc('id')
            ->paginate(15, ['*'], 'activas_page')
            ->withQueryString();

        $cotizacionesCerradas = (clone $consultaBase)
            ->whereIn('estado', ['RECHAZADA', 'VENCIDA', 'CANCELADA'])
            ->orderByDesc('id')
            ->paginate(15, ['*'], 'cerradas_page')
            ->withQueryString();

        return view('comercial.cotizaciones.index', compact('cotizacionesActivas', 'cotizacionesCerradas', 'folio'));
    }

    public function create()
    {
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $servicios = Servicio::where('activo', true)->orderBy('servicio')->get();

        return view('comercial.cotizaciones.create', compact('clientes', 'servicios'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate(array_merge([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'vigencia' => 'nullable|date|after_or_equal:fecha',
            'observaciones' => 'nullable|string',
        ], $this->reglasLineas()));

        $totales = $this->calcularTotales($validated['lineas']);

        DB::transaction(function () use ($validated, $totales) {
            $cotizacion = Cotizacion::create([
                'folio' => $this->generarFolio(),
                'cliente_id' => $validated['cliente_id'],
                'usuario_id' => Auth::id(),
                'fecha' => $validated['fecha'],
                'vigencia' => $validated['vigencia'] ?? null,
                'estado' => 'PENDIENTE',
                'subtotal' => $totales['subtotal'],
                'descuento' => 0,
                'impuestos' => $totales['impuestos'],
                'total' => $totales['total'],
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            foreach ($validated['lineas'] as $linea) {
                CotizacionDetalle::create([
                    'cotizacion_id' => $cotizacion->id,
                    'servicio_id' => $linea['servicio_id'],
                    'cantidad' => $linea['cantidad'],
                    'precio_unitario' => $linea['precio_unitario'],
                    'descuento' => $this->montoDescuento($linea), // ya convertido a monto, sin importar si venía como % o fijo
                    'subtotal' => $this->subtotalLinea($linea),
                ]);
            }
        });

        return redirect()
            ->route('comercial.cotizaciones.index')
            ->with('success', 'Cotización creada correctamente.');
    }

    public function edit(string $id)
    {
        $cotizacion = Cotizacion::with('detalles')->findOrFail($id);
        $clientes = Cliente::where('activo', true)->orderBy('nombre')->get();
        $servicios = Servicio::where('activo', true)->orderBy('servicio')->get();

        return view('comercial.cotizaciones.edit', compact('cotizacion', 'clientes', 'servicios'));
    }

    public function update(Request $request, string $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);

        $validated = $request->validate(array_merge([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'vigencia' => 'nullable|date|after_or_equal:fecha',
            'estado' => 'required|in:PENDIENTE,ACEPTADA,RECHAZADA,VENCIDA,CANCELADA',
            'observaciones' => 'nullable|string',
        ], $this->reglasLineas()));

        $totales = $this->calcularTotales($validated['lineas']);

        DB::transaction(function () use ($cotizacion, $validated, $totales) {
            $cotizacion->update([
                'cliente_id' => $validated['cliente_id'],
                'fecha' => $validated['fecha'],
                'vigencia' => $validated['vigencia'] ?? null,
                'estado' => $validated['estado'],
                'subtotal' => $totales['subtotal'],
                'impuestos' => $totales['impuestos'],
                'total' => $totales['total'],
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            CotizacionDetalle::where('cotizacion_id', $cotizacion->id)->delete();

            foreach ($validated['lineas'] as $linea) {
                CotizacionDetalle::create([
                    'cotizacion_id' => $cotizacion->id,
                    'servicio_id' => $linea['servicio_id'],
                    'cantidad' => $linea['cantidad'],
                    'precio_unitario' => $linea['precio_unitario'],
                    'descuento' => $this->montoDescuento($linea),
                    'subtotal' => $this->subtotalLinea($linea),
                ]);
            }
        });

        return redirect()
            ->route('comercial.cotizaciones.index')
            ->with('success', 'Cotización actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $cotizacion = Cotizacion::findOrFail($id);
        $cotizacion->update(['estado' => 'CANCELADA']);

        return redirect()
            ->route('comercial.cotizaciones.index')
            ->with('success', 'Cotización cancelada correctamente.');
    }
}