<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\CategoriaServicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with('categoria')->orderBy('servicio')->paginate(15);

        return view('comercial.servicios.index', compact('servicios'));
    }

    public function create()
    {
        $categorias = CategoriaServicio::where('activo', true)->get();

        return view('comercial.servicios.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias_servicio,id',
            'servicio' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'tipo_precio' => 'nullable|string|max:30',
        ]);

        $validated['activo'] = true;
        $validated['promocion'] = $request->boolean('promocion');

        Servicio::create($validated);

        return redirect()
            ->route('comercial.servicios.index')
            ->with('success', 'Servicio creado correctamente.');
    }

    public function edit(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $categorias = CategoriaServicio::where('activo', true)->get();

        return view('comercial.servicios.edit', compact('servicio', 'categorias'));
    }

    public function update(Request $request, string $id)
    {
        $servicio = Servicio::findOrFail($id);

        $validated = $request->validate([
            'categoria_id' => 'required|exists:categorias_servicio,id',
            'servicio' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'precio_base' => 'required|numeric|min:0',
            'tipo_precio' => 'nullable|string|max:30',
            'activo' => 'required|boolean',
        ]);

        $validated['promocion'] = $request->boolean('promocion');

        $servicio->update($validated);

        return redirect()
            ->route('comercial.servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);
        $servicio->update(['activo' => false]);

        return redirect()
            ->route('comercial.servicios.index')
            ->with('success', 'Servicio desactivado correctamente.');
    }
}