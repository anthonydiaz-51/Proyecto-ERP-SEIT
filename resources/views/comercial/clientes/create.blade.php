<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Nuevo cliente</h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('comercial.clientes.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tipo de cliente</label>
                    <select name="tipo_cliente" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="PERSONA" {{ old('tipo_cliente') == 'PERSONA' ? 'selected' : '' }}>Persona</option>
                        <option value="EMPRESA" {{ old('tipo_cliente') == 'EMPRESA' ? 'selected' : '' }}>Empresa</option>
                    </select>
                    @error('tipo_cliente') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}"
                           class="mt-1 block w-full rounded-md border-gray-300">
                    @error('nombre') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Razón social (si aplica)</label>
                    <input type="text" name="razon_social" value="{{ old('razon_social') }}"
                           class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">RFC</label>
                    <input type="text" name="rfc" value="{{ old('rfc') }}"
                           class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="{{ old('telefono') }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Notas</label>
                    <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notas') }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="reset"
                        class="px-4 py-2 text-sm text-gray-600"
                    >
                        Limpiar
                    </button>

                    <a
                        href="{{ route('comercial.clientes.index') }}"
                        class="px-4 py-2 text-sm text-gray-600"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700"
                    >
                        Guardar cliente
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>