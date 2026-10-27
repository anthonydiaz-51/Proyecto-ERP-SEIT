<?php

namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use App\Models\Productos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class MovimientoInventarioController extends Controller
{
    public function index(Request $request)
    {
        $movimientosQuery = MovimientoInventario::query()->with(['producto.categoria', 'usuario']);

        if ($request->filled('tipo')) {
            $movimientosQuery->where('tipo', $request->input('tipo'));
        }

        if ($request->filled('q')) {
            $termino = trim($request->string('q')->toString());
            $movimientosQuery->where(function (Builder $query) use ($termino) {
                $query->where('referencia', 'like', "%{$termino}%")
                    ->orWhere('motivo', 'like', "%{$termino}%")
                    ->orWhereHas('producto', fn (Builder $producto) => $producto
                        ->where('nombre', 'like', "%{$termino}%")
                        ->orWhere('codigo', 'like', "%{$termino}%"));
            });
        }

        $movimientos = $movimientosQuery->orderByDesc('created_at')->orderByDesc('id')->paginate(15)->withQueryString();

        return view('inventario.movimientos.index', compact('movimientos'));
    }

    public function create(Request $request)
    {
        $productos = Productos::query()
            ->with('inventario')
            ->where('activo', true)
            ->orderBy('nombre')
            ->get();

        return view('inventario.movimientos.create', [
            'productos' => $productos,
            'productoSeleccionado' => $request->input('producto_id'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => ['required', 'exists:productos,id'],
            'tipo' => ['required', 'in:ENTRADA,SALIDA,AJUSTE'],
            'cantidad' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'referencia' => ['nullable', 'string', 'max:100'],
            'motivo' => ['nullable', 'string', 'max:255'],
            'ubicacion' => ['nullable', 'string', 'max:100'],
        ]);

        if ($validated['tipo'] !== 'AJUSTE' && (float) $validated['cantidad'] <= 0) {
            throw ValidationException::withMessages([
                'cantidad' => 'Las entradas y salidas deben ser mayores que cero.',
            ]);
        }

        DB::transaction(function () use ($validated) {
            $producto = Productos::query()->whereKey($validated['producto_id'])->lockForUpdate()->firstOrFail();
            if (!$producto->activo) {
                throw ValidationException::withMessages([
                    'producto_id' => 'No se pueden registrar movimientos para un producto inactivo.',
                ]);
            }

            $inventario = $producto->inventario()->lockForUpdate()->first();
            if (!$inventario) {
                $inventario = $producto->inventario()->create([
                    'existencia' => 0,
                    'ubicacion' => $validated['ubicacion'] ?? null,
                ]);
            }

            $existenciaActual = (float) ($inventario->existencia ?? 0);
            $cantidad = (float) $validated['cantidad'];

            if ($validated['tipo'] === 'SALIDA' && $cantidad > $existenciaActual) {
                throw ValidationException::withMessages([
                    'cantidad' => 'La salida supera la existencia actual (' . number_format($existenciaActual, 2) . ').',
                ]);
            }

            $nuevaExistencia = match ($validated['tipo']) {
                'ENTRADA' => $existenciaActual + $cantidad,
                'SALIDA' => $existenciaActual - $cantidad,
                'AJUSTE' => $cantidad,
            };

            $inventario->existencia = round($nuevaExistencia, 2);
            if (array_key_exists('ubicacion', $validated)) {
                $inventario->ubicacion = $validated['ubicacion'];
            }
            if ($inventario->exists) {
                $inventario->updated_at = now();
            }
            $inventario->save();

            $producto->movimientos()->create([
                'tipo' => $validated['tipo'],
                'cantidad' => $cantidad,
                'referencia' => $validated['referencia'] ?? null,
                'motivo' => $validated['motivo'] ?? null,
                'usuario_id' => Auth::id(),
            ]);
        });

        return redirect()->route('inventario.movimientos.index')->with('success', 'Movimiento aplicado y registrado en el historial.');
    }
}
