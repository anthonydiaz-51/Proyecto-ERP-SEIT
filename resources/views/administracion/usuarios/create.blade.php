<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nuevo usuario</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('administracion.usuarios.store') }}">
                @csrf

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Apellido</label>
                        <input type="text" name="apellido" value="{{ old('apellido') }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('apellido') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="mt-1 block w-full rounded-md border-gray-300">
                    @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Rol</label>
                    <select name="rol_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="1" {{ old('rol_id') == 1 ? 'selected' : '' }}>Administrador</option>
                        <option value="2" {{ old('rol_id') == 2 ? 'selected' : '' }}>Gerencia</option>
                        <option value="3" {{ old('rol_id') == 3 ? 'selected' : '' }}>Ventas</option>
                        <option value="4" {{ old('rol_id') == 4 ? 'selected' : '' }}>Técnico</option>
                        <option value="5" {{ old('rol_id') == 5 ? 'selected' : '' }}>Practicante</option>
                    </select>
                    @error('rol_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input type="password" name="password"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('administracion.usuarios.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>