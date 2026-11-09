<x-app-layout>
    @php
        $esAdministrador = (int) auth()->user()->rol_id === 1;
        $esPropio = (int) auth()->id() === (int) $usuario->id;
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Editar usuario</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('administracion.usuarios.update', $usuario) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $usuario->nombre) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input type="text" name="apellido" value="{{ old('apellido', $usuario->apellido) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('apellido') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $usuario->email) }}"
                           class="mt-1 block w-full rounded-md border-gray-300">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Rol</label>
                    @if($esAdministrador)
                        <select name="rol_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="1" {{ old('rol_id', $usuario->rol_id) == 1 ? 'selected' : '' }}>Administrador</option>
                            <option value="2" {{ old('rol_id', $usuario->rol_id) == 2 ? 'selected' : '' }}>Gerencia</option>
                            <option value="3" {{ old('rol_id', $usuario->rol_id) == 3 ? 'selected' : '' }}>Ventas</option>
                            <option value="4" {{ old('rol_id', $usuario->rol_id) == 4 ? 'selected' : '' }}>Técnico</option>
                            <option value="5" {{ old('rol_id', $usuario->rol_id) == 5 ? 'selected' : '' }}>Practicante</option>
                        </select>
                    @else
                        @php
                            $nombreRol = [1 => 'Administrador', 2 => 'Gerencia', 3 => 'Ventas', 4 => 'Técnico', 5 => 'Practicante'][$usuario->rol_id] ?? 'Sin rol asignado';
                        @endphp
                        <p class="mt-1 rounded-md border border-gray-300 bg-gray-100 px-3 py-2 text-sm text-gray-700">
                            {{ $nombreRol }} <span class="text-xs text-gray-500"></span>
                        </p>
                        <p class="text-gray-500 text-xs mt-1">Solo un administrador puede cambiar roles.</p>
                    @endif
                    @error('rol_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                @if($esAdministrador || $esPropio)
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        @if($esPropio && !$esAdministrador)
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Contraseña actual</label>
                                <input type="password" name="current_password" autocomplete="current-password"
                                       class="mt-1 block w-full rounded-md border-gray-300">
                                @error('current_password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nueva contraseña (opcional)</label>
                            <input type="password" name="password" autocomplete="new-password"
                                   class="mt-1 block w-full rounded-md border-gray-300"
                                   placeholder="Dejar en blanco para no cambiarla">
                            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Confirmar nueva contraseña</label>
                            <input type="password" name="password_confirmation" autocomplete="new-password"
                                   class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                    </div>
                @else
                    <p class="mb-4 text-sm text-gray-500">
                        Solo el administrador puede cambiar la contraseña de otra cuenta.
                    </p>
                @endif

                @if((int) auth()->user()->rol_id === 1)
                    <div class="mb-6">
                        <label class="inline-flex items-center">
                            <input type="hidden" name="activo" value="0">
                            <input type="checkbox" name="activo" value="1" {{ old('activo', $usuario->activo) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Usuario activo</span>
                        </label>
                    </div>
                @else
                    <div class="mb-6 text-sm text-gray-500">
                        Estado: <span class="font-medium">{{ $usuario->activo ? 'Activo' : 'Desactivado' }}</span>
                    </div>
                @endif

                <div class="flex justify-end gap-3">
                    <a href="{{ route('administracion.usuarios.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            @if((int) auth()->user()->rol_id === 1 && (int) $usuario->id !== (int) auth()->id())
                <form method="POST" action="{{ route('administracion.usuarios.destroy', $usuario) }}"
                      onsubmit="return confirm('¿Desactivar este usuario?');" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 text-sm hover:underline">Desactivar usuario</button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
