<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Tickets / Órdenes de Servicio</h2>
            <a href="{{ route('sistemas.ordenes.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nueva orden
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Técnico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioridad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Costo</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($ordenes as $orden)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $orden->folio }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $orden->cliente->nombre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $orden->tecnico->nombre ?? 'Sin asignar' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $coloresPrioridad = [
                                        'URGENTE' => 'text-red-600 font-semibold',
                                        'ALTA' => 'text-orange-600',
                                        'MEDIA' => 'text-amber-600',
                                        'BAJA' => 'text-gray-500',
                                    ];
                                @endphp
                                <span class="{{ $coloresPrioridad[$orden->prioridad] ?? 'text-gray-500' }}">
                                    {{ $orden->prioridad ?? '—' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $coloresEstado = [
                                        'RECIBIDO' => 'text-blue-600',
                                        'DIAGNOSTICO' => 'text-indigo-600',
                                        'COTIZACION' => 'text-purple-600',
                                        'AUTORIZADO' => 'text-teal-600',
                                        'EN_PROCESO' => 'text-amber-600',
                                        'LISTO' => 'text-green-600',
                                        'ENTREGADO' => 'text-gray-500',
                                        'CANCELADO' => 'text-red-500',
                                    ];
                                @endphp
                                <span class="{{ $coloresEstado[$orden->estado] ?? 'text-gray-500' }}">
                                    {{ $orden->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($orden->costo_total, 2) }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('sistemas.ordenes.edit', $orden) }}" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay órdenes de servicio registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $ordenes->links() }}
        </div>
    </div>
</x-app-layout>

