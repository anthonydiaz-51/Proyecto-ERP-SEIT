<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::orderBy('nombre')->paginate(15);

        return view('administracion.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('administracion.usuarios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => 'required|integer|between:1,5',
        ]);

        Usuario::create([
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol_id' => $validated['rol_id'],
            'activo' => true,
        ]);

        return redirect()
            ->route('administracion.usuarios.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        return view('administracion.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'password' => 'nullable|string|min:8|confirmed',
            'rol_id' => 'required|integer|between:1,5',
            'activo' => 'required|boolean',
        ]);

        $datos = [
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'rol_id' => $validated['rol_id'],
            'activo' => $validated['activo'],
        ];

        if (!empty($validated['password'])) {
            $datos['password'] = Hash::make($validated['password']);
        }

        $usuario->update($datos);

        return redirect()
            ->route('administracion.usuarios.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $usuario = Usuario::findOrFail($id);

        if ($usuario->id === Auth::id()) {
            return redirect()
                ->route('administracion.usuarios.index')
                ->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        $usuario->update(['activo' => false]);

        return redirect()
            ->route('administracion.usuarios.index')
            ->with('success', 'Usuario desactivado correctamente.');
    }
}