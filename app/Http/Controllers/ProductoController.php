<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use App\Models\Inventario;
use App\Models\MovimientoInventario;
use App\Models\Productos;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        $productosQuery = Productos::query()
            ->with(['categoria', 'inventario'])
            ->where('activo', true);

        if ($request->filled('q')) {
            $termino = trim($request->string('q')->toString());
            $productosQuery->where(function (Builder $query) use ($termino) {
                $query->where('nombre', 'like', "%{$termino}%")
                    ->orWhere('codigo', 'like', "%{$termino}%")
                    ->orWhere('descripcion', 'like', "%{$termino}%");
            });
        }

        if ($request->filled('categoria_id')) {
            $productosQuery->where('categoria_id', $request->input('categoria_id'));
        }

        match ($request->input('stock')) {
            'agotado' => $productosQuery->where(function (Builder $query) {
                $query->whereDoesntHave('inventario')
                    ->orWhereHas('inventario', fn (Builder $stock) => $stock->where('existencia', '<=', 0));
            }),
            'bajo' => $productosQuery
                ->where('stock_minimo', '>', 0)
                ->whereHas('inventario', fn (Builder $stock) => $stock
                    ->where('existencia', '>', 0)
                    ->whereColumn('inventario.existencia', '<=', 'productos.stock_minimo')),
            'disponible' => $productosQuery->whereHas('inventario', fn (Builder $stock) => $stock->where('existencia', '>', 0)),
            default => null,
        };

        match ($request->input('orden')) {
            'nombre_desc' => $productosQuery->orderByDesc('nombre'),
            'codigo' => $productosQuery->orderBy('codigo')->orderBy('nombre'),
            'stock_asc' => $productosQuery->withSum('inventario', 'existencia')->orderBy('inventario_sum_existencia')->orderBy('nombre'),
            'stock_desc' => $productosQuery->withSum('inventario', 'existencia')->orderByDesc('inventario_sum_existencia')->orderBy('nombre'),
            'precio_asc' => $productosQuery->orderBy('precio_venta')->orderBy('nombre'),
            'precio_desc' => $productosQuery->orderByDesc('precio_venta')->orderBy('nombre'),
            default => $productosQuery->orderBy('nombre'),
        };

        $productos = $productosQuery->paginate(12)->withQueryString();
        $categorias = CategoriaProducto::query()->where('activo', true)->orderBy('nombre')->get();

        $productosActivos = Productos::query()->where('activo', true);
        $totalProductos = (clone $productosActivos)->count();
        $sinExistencia = (clone $productosActivos)->where(function (Builder $query) {
            $query->whereDoesntHave('inventario')
                ->orWhereHas('inventario', fn (Builder $stock) => $stock->where('existencia', '<=', 0));
        })->count();
        $stockBajo = (clone $productosActivos)
            ->where('stock_minimo', '>', 0)
            ->whereHas('inventario', fn (Builder $stock) => $stock
                ->where('existencia', '>', 0)
                ->whereColumn('inventario.existencia', '<=', 'productos.stock_minimo'))
            ->count();
        $unidadesEnStock = Inventario::query()
            ->whereHas('producto', fn (Builder $producto) => $producto->where('activo', true))
            ->sum('existencia');
        $movimientosRecientes = MovimientoInventario::query()->whereDate('created_at', now()->toDateString())->count();

        return view('inventario.index', compact(
            'productos',
            'categorias',
            'totalProductos',
            'sinExistencia',
            'stockBajo',
            'unidadesEnStock',
            'movimientosRecientes'
        ));
    }

    public function create()
    {
        $categorias = CategoriaProducto::query()->where('activo', true)->orderBy('nombre')->get();

        return view('inventario.productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => ['nullable', Rule::exists('categorias_producto', 'id')->where('activo', true)],
            'codigo' => ['nullable', 'string', 'max:50', Rule::unique('productos', 'codigo')],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio_compra' => ['nullable', 'numeric', 'min:0'],
            'precio_venta' => ['nullable', 'numeric', 'min:0'],
            'stock_minimo' => ['nullable', 'integer', 'min:0'],
            'existencia_inicial' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'ubicacion' => ['nullable', 'string', 'max:100'],
            'motivo_inicial' => ['nullable', 'string', 'max:255'],
        ]);

        $existenciaInicial = (float) ($validated['existencia_inicial'] ?? 0);
        $ubicacion = $validated['ubicacion'] ?? null;
        $motivoInicial = $validated['motivo_inicial'] ?? 'Existencia inicial al registrar el producto';
        unset($validated['existencia_inicial'], $validated['ubicacion'], $validated['motivo_inicial']);
        $validated['activo'] = true;

        DB::transaction(function () use ($validated, $existenciaInicial, $ubicacion, $motivoInicial) {
            $producto = Productos::create($validated);

            Inventario::create([
                'producto_id' => $producto->id,
                'existencia' => $existenciaInicial,
                'ubicacion' => $ubicacion,
            ]);

            if ($existenciaInicial > 0) {
                $producto->movimientos()->create([
                    'tipo' => 'ENTRADA',
                    'cantidad' => $existenciaInicial,
                    'referencia' => 'ALTA INICIAL',
                    'motivo' => $motivoInicial,
                    'usuario_id' => auth()->id(),
                ]);
            }
        });

        return redirect()->route('inventario.productos.index')->with('success', 'Producto agregado al inventario.');
    }

    public function edit(string $id)
    {
        $producto = Productos::with('inventario')->findOrFail($id);
        $categorias = CategoriaProducto::query()
            ->where('activo', true)
            ->orWhere('id', $producto->categoria_id)
            ->orderBy('nombre')
            ->get();

        return view('inventario.productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $producto = Productos::with('inventario')->findOrFail($id);

        $validated = $request->validate([
            'categoria_id' => ['nullable', Rule::exists('categorias_producto', 'id')],
            'codigo' => ['nullable', 'string', 'max:50', Rule::unique('productos', 'codigo')->ignore($producto->id)],
            'nombre' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'precio_compra' => ['nullable', 'numeric', 'min:0'],
            'precio_venta' => ['nullable', 'numeric', 'min:0'],
            'stock_minimo' => ['nullable', 'integer', 'min:0'],
            'ubicacion' => ['nullable', 'string', 'max:100'],
            'activo' => ['required', 'boolean'],
        ]);

        $ubicacion = $validated['ubicacion'] ?? null;
        unset($validated['ubicacion']);

        DB::transaction(function () use ($producto, $validated, $ubicacion) {
            $producto->update($validated);
            $inventario = $producto->inventario()->firstOrNew();
            $inventario->ubicacion = $ubicacion;
            $inventario->existencia ??= 0;
            if ($inventario->exists) {
                $inventario->updated_at = now();
            }
            $inventario->save();
        });

        return redirect()->route('inventario.productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $producto = Productos::findOrFail($id);
        $producto->update(['activo' => false]);

        return redirect()->route('inventario.productos.index')->with('success', 'Producto desactivado; su historial de movimientos se conservó.');
    }
}
