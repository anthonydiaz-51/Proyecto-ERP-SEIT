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
        $veTodos = in_array((int) Auth::user()->rol_id, [1, 2], true);
        $consulta = Usuario::query();

        if (!$veTodos) {
            $consulta->whereKey(Auth::id());
        }

        $usuarios = $consulta->orderBy('nombre')->paginate(15);

        return view('administracion.usuarios.index', compact('usuarios', 'veTodos'));
    }

    public function create()
    {
        abort_unless(in_array((int) Auth::user()->rol_id, [1, 2], true), 403);

        return view('administracion.usuarios.create');
    }

    public function store(Request $request)
    {
        abort_unless(in_array((int) Auth::user()->rol_id, [1, 2], true), 403);

        $esAdministrador = (int) Auth::user()->rol_id === 1;

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email',
            'password' => 'required|string|min:8|confirmed',
            'rol_id' => $esAdministrador
                ? 'required|integer|in:1,2,3,4,5'
                : 'required|integer|in:2,3,4,5',
        ], [
            'rol_id.in' => 'Solo el administrador puede asignar el rol Administrador.',
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
        $veTodos = in_array((int) Auth::user()->rol_id, [1, 2], true);

        abort_unless($veTodos || (int) $usuario->id === (int) Auth::id(), 403);

        return view('administracion.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, string $id)
    {
        $usuario = Usuario::findOrFail($id);
        $rolUsuarioActual = (int) Auth::user()->rol_id;
        $veTodos = in_array($rolUsuarioActual, [1, 2], true);
        $esPropio = (int) $usuario->id === (int) Auth::id();
        abort_unless($veTodos || $esPropio, 403);

        $esAdministrador = $rolUsuarioActual === 1;
        $puedeCambiarPassword = $esAdministrador || $esPropio;

        $reglas = [
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:usuarios,email,' . $usuario->id,
            'rol_id' => $esAdministrador
                ? 'required|integer|in:1,2,3,4,5'
                : 'prohibited',
            'password' => $puedeCambiarPassword
                ? 'nullable|string|min:8|confirmed'
                : 'prohibited',
        ];

        if ($esPropio && !$esAdministrador) {
            $reglas['current_password'] = 'required_with:password|current_password';
        } elseif (!$puedeCambiarPassword) {
            $reglas['current_password'] = 'prohibited';
        }

        if ($esAdministrador) {
            $reglas['activo'] = 'required|boolean';
        }

        $validated = $request->validate($reglas, [
            'rol_id.prohibited' => 'Solo el administrador puede cambiar los roles de los usuarios.',
        ]);

        $datos = [
            'nombre' => $validated['nombre'],
            'apellido' => $validated['apellido'],
            'email' => $validated['email'],
            'rol_id' => $esAdministrador ? $validated['rol_id'] : $usuario->rol_id,
            // Gerencia puede editar datos, pero no cambiar el estado activo.
            'activo' => $esAdministrador ? $validated['activo'] : $usuario->activo,
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
        abort_unless((int) Auth::user()->rol_id === 1, 403, 'Solo el administrador puede desactivar usuarios.');

        $usuario = Usuario::findOrFail($id);

        if ((int) $usuario->id === (int) Auth::id()) {
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
