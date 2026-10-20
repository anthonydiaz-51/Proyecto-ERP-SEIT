<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Cotizaciones</h2>
            <a href="{{ route('comercial.cotizaciones.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nueva cotización
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
        <form method="GET" action="{{ route('comercial.cotizaciones.index') }}" class="mb-4 flex flex-wrap items-end gap-3">
            <div class="w-full max-w-sm">
                <label for="folio" class="mb-1 block text-sm font-medium text-gray-700">Buscar por folio</label>
                <input
                    id="folio"
                    type="search"
                    name="folio"
                    value="{{ $folio }}"
                    maxlength="50"
                    placeholder="Ej. COT-2026-001"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Buscar
            </button>
            @if($folio !== '')
                <a href="{{ route('comercial.cotizaciones.index') }}" class="px-2 py-2 text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
            @endif
        </form>

        @php
            $grupos = [
                [
                    'titulo' => 'Cotizaciones pendientes y aceptadas',
                    'cotizaciones' => $cotizacionesActivas,
                    'vacio' => 'No hay cotizaciones pendientes o aceptadas que coincidan con la búsqueda.',
                ],
                [
                    'titulo' => 'Cotizaciones rechazadas, vencidas o canceladas',
                    'cotizaciones' => $cotizacionesCerradas,
                    'vacio' => 'No hay cotizaciones rechazadas, vencidas o canceladas que coincidan con la búsqueda.',
                ],
            ];
            $colores = [
                'PENDIENTE' => 'text-amber-600',
                'ACEPTADA' => 'text-green-600',
                'RECHAZADA' => 'text-red-500',
                'VENCIDA' => 'text-gray-400',
                'CANCELADA' => 'text-gray-400',
            ];
        @endphp

        @foreach($grupos as $grupo)
            <section class="mb-8" aria-label="{{ $grupo['titulo'] }}">
                <h3 class="mb-3 text-lg font-semibold text-gray-800">{{ $grupo['titulo'] }}</h3>
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Folio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Estado</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($grupo['cotizaciones'] as $cotizacion)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $cotizacion->folio }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $cotizacion->cliente->nombre ?? '—' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $cotizacion->fecha }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($cotizacion->total, 2) }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="{{ $colores[$cotizacion->estado] ?? 'text-gray-500' }}">{{ $cotizacion->estado }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="{{ route('comercial.cotizaciones.edit', $cotizacion) }}" class="text-indigo-600 hover:underline">Editar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">{{ $grupo['vacio'] }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $grupo['cotizaciones']->links() }}
                </div>
            </section>
        @endforeach
    </div>
</x-app-layout>