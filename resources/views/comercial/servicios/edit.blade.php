<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Editar servicio</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('comercial.servicios.update', $servicio) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select name="categoria_id" class="mt-1 block w-full rounded-md border-gray-300">
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $servicio->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Servicio</label>
                    <input type="text" name="servicio" value="{{ old('servicio', $servicio->servicio) }}"
                           class="mt-1 block w-full rounded-md border-gray-300">
                    @error('servicio') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio base</label>
                        <input type="number" step="0.01" name="precio_base" value="{{ old('precio_base', $servicio->precio_base) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('precio_base') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de precio</label>
                        <input type="text" name="tipo_precio" value="{{ old('tipo_precio', $servicio->tipo_precio) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="promocion" value="1" {{ old('promocion', $servicio->promocion) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Marcar como promoción</span>
                    </label>
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1" {{ old('activo', $servicio->activo) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-700">Servicio activo</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('comercial.servicios.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('comercial.servicios.destroy', $servicio) }}"
                  onsubmit="return confirm('¿Desactivar este servicio?');" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 text-sm hover:underline">Desactivar servicio</button>
            </form>
        </div>
    </div>
</x-app-layout>