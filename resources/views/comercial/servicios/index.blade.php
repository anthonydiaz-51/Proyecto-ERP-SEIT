<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Servicios</h2>
            <a href="{{ route('comercial.servicios.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nuevo servicio
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-4">
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Categoría</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Precio base</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Promoción</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activo</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($servicios as $servicio)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $servicio->servicio }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $servicio->categoria->nombre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($servicio->precio_base, 2) }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($servicio->promocion)
                                    <span class="text-amber-600">Sí</span>
                                @else
                                    <span class="text-gray-400">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @if($servicio->activo)
                                    <span class="text-green-600">Sí</span>
                                @else
                                    <span class="text-red-500">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('comercial.servicios.edit', $servicio) }}" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay servicios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $servicios->links() }}
        </div>
    </div>
</x-app-layout>