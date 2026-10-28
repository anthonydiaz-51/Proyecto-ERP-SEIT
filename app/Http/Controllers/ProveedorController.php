<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $proveedoresQuery = Proveedor::query();

        if ($request->filled('q')) {
            $termino = trim($request->input('q'));
            $proveedoresQuery->where(function (Builder $query) use ($termino) {
                $query->where('nombre', 'like', "%{$termino}%")
                    ->orWhere('razon_social', 'like', "%{$termino}%")
                    ->orWhere('rfc', 'like', "%{$termino}%")
                    ->orWhere('contacto', 'like', "%{$termino}%")
                    ->orWhere('email', 'like', "%{$termino}%");
            });
        }

        if ($request->input('estado') === 'activos') {
            $proveedoresQuery->where('activo', true);
        } elseif ($request->input('estado') === 'inactivos') {
            $proveedoresQuery->where('activo', false);
        }

        $proveedores = $proveedoresQuery
            ->orderByDesc('activo')
            ->orderBy('nombre')
            ->paginate(12)
            ->withQueryString();

        $totalProveedores = Proveedor::count();
        $proveedoresActivos = Proveedor::where('activo', true)->count();
        $proveedoresInactivos = $totalProveedores - $proveedoresActivos;

        return view('compras.proveedores.index', compact(
            'proveedores',
            'totalProveedores',
            'proveedoresActivos',
            'proveedoresInactivos'
        ));
    }

    public function create()
    {
        return view('compras.proveedores.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'rfc' => $request->filled('rfc') ? mb_strtoupper(trim($request->input('rfc'))) : null,
            'email' => $request->filled('email') ? mb_strtolower(trim($request->input('email'))) : null,
        ]);

        $validated = $request->validate($this->rules());
        $validated['activo'] = true;

        Proveedor::create($validated);

        return redirect()
            ->route('compras.proveedores.index')
            ->with('success', 'Proveedor registrado correctamente.');
    }

    public function edit(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        return view('compras.proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $request->merge([
            'rfc' => $request->filled('rfc') ? mb_strtoupper(trim($request->input('rfc'))) : null,
            'email' => $request->filled('email') ? mb_strtolower(trim($request->input('email'))) : null,
        ]);

        $validated = $request->validate($this->rules($proveedor));
        $validated['activo'] = $request->boolean('activo');

        $proveedor->update($validated);

        return redirect()
            ->route('compras.proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update(['activo' => false]);

        return redirect()
            ->route('compras.proveedores.index')
            ->with('success', 'Proveedor desactivado; sus datos se conservaron.');
    }

    private function rules(?Proveedor $proveedor = null): array
    {
        return [
            'tipo_proveedor' => ['required', Rule::in(['PERSONA', 'EMPRESA'])],
            'nombre' => ['required', 'string', 'max:150'],
            'razon_social' => ['nullable', 'string', 'max:200'],
            'rfc' => ['nullable', 'string', 'max:20', Rule::unique('proveedores', 'rfc')->ignore($proveedor?->id)],
            'contacto' => ['nullable', 'string', 'max:150'],
            'telefono' => ['nullable', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'sitio_web' => ['nullable', 'url', 'max:200'],
            'calle' => ['nullable', 'string', 'max:150'],
            'numero_exterior' => ['nullable', 'string', 'max:30'],
            'numero_interior' => ['nullable', 'string', 'max:30'],
            'colonia' => ['nullable', 'string', 'max:100'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', 'string', 'max:100'],
            'codigo_postal' => ['nullable', 'string', 'max:10'],
            'notas' => ['nullable', 'string'],
        ];
    }
}
