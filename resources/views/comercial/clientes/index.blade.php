<x-app-layout>
    <x-slot name="header">
        @if(session('success'))
            <div class="max-w-7xl mx-auto mt-4">
                <div class="bg-green-50 text-green-700 px-4 py-3 rounded-md text-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Clientes</h2>
            <a href="{{ route('comercial.clientes.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nuevo cliente
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activo</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($clientes as $cliente)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $cliente->nombre }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->tipo_cliente }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cliente->telefono }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($cliente->activo)
                                    <span class="text-green-600">Sí</span>
                                @else
                                    <span class="text-red-500">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('comercial.clientes.edit', $cliente) }}" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay clientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $clientes->links() }}
        </div>
    </div>
</x-app-layout>