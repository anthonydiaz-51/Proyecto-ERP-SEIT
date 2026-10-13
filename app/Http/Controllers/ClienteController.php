<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::orderBy('nombre')->paginate(15);

        return view('comercial.clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('comercial.clientes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_cliente' => 'required|in:PERSONA,EMPRESA',
            'nombre' => 'required|string|max:150',
            'razon_social' => 'nullable|string|max:200',
            'rfc' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'notas' => 'nullable|string',
        ]);

        $validated['activo'] = true;

        Cliente::create($validated);

        return redirect()
            ->route('comercial.clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    $cliente = Cliente::findOrFail($id);

    return view('comercial.clientes.edit', compact('cliente'));
    }

    public function update(Request $request, string $id)
    {
        $cliente = Cliente::findOrFail($id);

        $validated = $request->validate([
            'tipo_cliente' => 'required|in:PERSONA,EMPRESA',
            'nombre' => 'required|string|max:150',
            'razon_social' => 'nullable|string|max:200',
            'rfc' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'notas' => 'nullable|string',
            'activo' => 'required|boolean',
        ]);

        $cliente->update($validated);

        return redirect()
            ->route('comercial.clientes.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update(['activo' => false]);

        return redirect()
            ->route('comercial.clientes.index')
            ->with('success', 'Cliente desactivado correctamente.');
    }
}
