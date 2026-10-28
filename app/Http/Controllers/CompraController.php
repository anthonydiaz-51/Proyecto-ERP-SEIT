<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Inventario;
use App\Models\Productos;
use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'desde' => ['nullable', 'date'],
            'hasta' => ['nullable', 'date', 'after_or_equal:desde'],
        ]);

        $comprasQuery = Compra::query()->with(['proveedor', 'usuario'])->withCount('detalles');

        if ($request->filled('q')) {
            $termino = trim($request->input('q'));
            $comprasQuery->where(function (Builder $query) use ($termino) {
                if (ctype_digit($termino)) {
                    $query->where('id', (int) $termino)->orWhere('referencia_proveedor', 'like', "%{$termino}%");
                } else {
                    $query->where('referencia_proveedor', 'like', "%{$termino}%");
                }

                $query->orWhereHas('proveedor', fn (Builder $proveedor) => $proveedor
                    ->where('nombre', 'like', "%{$termino}%")
                    ->orWhere('razon_social', 'like', "%{$termino}%")
                    ->orWhere('rfc', 'like', "%{$termino}%"));
            });
        }

        if ($request->filled('desde')) {
            $comprasQuery->whereDate('fecha', '>=', $request->input('desde'));
        }

        if ($request->filled('hasta')) {
            $comprasQuery->whereDate('fecha', '<=', $request->input('hasta'));
        }

        $compras = $comprasQuery->orderByDesc('fecha')->orderByDesc('id')->paginate(15)->withQueryString();
        $totalCompras = Compra::count();
        $importeMes = Compra::query()
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('total');

        return view('compras.index', compact('compras', 'totalCompras', 'importeMes'));
    }

    public function create()
    {
        $proveedores = Proveedor::query()->where('activo', true)->orderBy('nombre')->get();
        $productos = Productos::query()
            ->where('activo', true)
            ->orderBy('nombre')
            ->get(['id', 'codigo', 'nombre', 'precio_compra']);

        return view('compras.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proveedor_id' => ['required', Rule::exists('proveedores', 'id')->where('activo', true)],
            'fecha' => ['required', 'date'],
            'referencia_proveedor' => ['nullable', 'string', 'max:100'],
            'tasa_impuesto' => ['required', 'numeric', 'min:0', 'max:100'],
            'observaciones' => ['nullable', 'string'],
            'lineas' => ['required', 'array', 'min:1'],
            'lineas.*.producto_id' => ['required', 'distinct', Rule::exists('productos', 'id')->where('activo', true)],
            'lineas.*.cantidad' => ['required', 'numeric', 'gt:0', 'max:99999999.99'],
            'lineas.*.precio_unitario' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'lineas.*.ubicacion' => ['nullable', 'string', 'max:100'],
        ]);

        $subtotal = 0;
        $lineasCalculadas = [];
        foreach ($validated['lineas'] as $linea) {
            $cantidad = (float) $linea['cantidad'];
            $precioUnitario = (float) $linea['precio_unitario'];
            $importeLinea = round($cantidad * $precioUnitario, 2);
            $subtotal += $importeLinea;
            $lineasCalculadas[] = [
                'producto_id' => (int) $linea['producto_id'],
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'subtotal' => $importeLinea,
                'ubicacion' => $linea['ubicacion'] ?? null,
            ];
        }

        $subtotal = round($subtotal, 2);
        $tasaImpuesto = (float) $validated['tasa_impuesto'];
        $impuestos = round($subtotal * $tasaImpuesto / 100, 2);
        $total = round($subtotal + $impuestos, 2);

        $compra = DB::transaction(function () use ($validated, $lineasCalculadas, $subtotal, $tasaImpuesto, $impuestos, $total) {
            $proveedor = Proveedor::query()->whereKey($validated['proveedor_id'])->lockForUpdate()->firstOrFail();
            if (!$proveedor->activo) {
                throw ValidationException::withMessages([
                    'proveedor_id' => 'No se pueden registrar compras para un proveedor inactivo.',
                ]);
            }

            $compra = Compra::create([
                'proveedor_id' => $proveedor->id,
                'usuario_id' => auth()->id(),
                'fecha' => $validated['fecha'],
                'referencia_proveedor' => $validated['referencia_proveedor'] ?? null,
                'tasa_impuesto' => $tasaImpuesto,
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'observaciones' => $validated['observaciones'] ?? null,
            ]);

            foreach ($lineasCalculadas as $linea) {
                $producto = Productos::query()
                    ->whereKey($linea['producto_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if (!$producto->activo) {
                    throw ValidationException::withMessages([
                        'lineas' => "El producto {$producto->nombre} está inactivo y no puede recibirse.",
                    ]);
                }

                $compra->detalles()->create($linea);
                $inventario = $producto->inventario()->lockForUpdate()->first();

                if (!$inventario) {
                    $inventario = new Inventario([
                        'existencia' => 0,
                        'ubicacion' => $linea['ubicacion'],
                    ]);
                    $inventario->producto_id = $producto->id;
                }

                $nuevaExistencia = round((float) ($inventario->existencia ?? 0) + $linea['cantidad'], 2);
                if ($nuevaExistencia > 99999999.99) {
                    throw ValidationException::withMessages([
                        'lineas' => "La recepción supera la capacidad de inventario para {$producto->nombre}.",
                    ]);
                }

                $inventario->existencia = $nuevaExistencia;
                if ($linea['ubicacion'] !== null && $linea['ubicacion'] !== '') {
                    $inventario->ubicacion = $linea['ubicacion'];
                }
                $inventario->updated_at = now();
                $inventario->save();

                // precio_compra queda como el último costo de adquisición registrado.
                $producto->update(['precio_compra' => $linea['precio_unitario']]);

                $producto->movimientos()->create([
                    'tipo' => 'ENTRADA',
                    'cantidad' => $linea['cantidad'],
                    'referencia' => 'COMPRA #' . $compra->id,
                    'motivo' => 'Recepción de compra a ' . $proveedor->nombre,
                    'usuario_id' => auth()->id(),
                ]);
            }

            return $compra;
        });

        return redirect()
            ->route('compras.show', $compra)
            ->with('success', 'Compra registrada y productos recibidos en inventario.');
    }

    public function show(string $id)
    {
        $compra = Compra::query()
            ->with(['proveedor', 'usuario', 'detalles.producto'])
            ->findOrFail($id);

        return view('compras.show', compact('compra'));
    }
}
