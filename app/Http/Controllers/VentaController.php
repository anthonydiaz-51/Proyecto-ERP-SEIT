<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\OrdenServicio;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $origen = $request->input('origen', 'todas');

        $cotizaciones = collect();
        $ordenes = collect();

        if (in_array($origen, ['todas', 'cotizaciones'])) {
            $cotizaciones = Cotizacion::with('cliente')
                ->where('estado', 'ACEPTADA')
                ->when($desde, fn ($q) => $q->whereDate('fecha', '>=', $desde))
                ->when($hasta, fn ($q) => $q->whereDate('fecha', '<=', $hasta))
                ->orderByDesc('fecha')
                ->get();
        }

        if (in_array($origen, ['todas', 'ordenes'])) {
            $ordenes = OrdenServicio::with('cliente')
                ->where('estado', 'ENTREGADO')
                ->when($desde, fn ($q) => $q->whereDate('fecha_entrega', '>=', $desde))
                ->when($hasta, fn ($q) => $q->whereDate('fecha_entrega', '<=', $hasta))
                ->orderByDesc('fecha_entrega')
                ->get();
        }

        $totalCotizaciones = $cotizaciones->sum('total');
        $totalOrdenes = $ordenes->sum('costo_total');

        return view('comercial.ventas.index', compact(
            'cotizaciones', 'ordenes', 'totalCotizaciones', 'totalOrdenes',
            'desde', 'hasta', 'origen'
        ));
    }
}