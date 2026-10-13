<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Cotizaciones</h2>
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
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($cotizaciones as $cotizacion)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $cotizacion->folio }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cotizacion->cliente->nombre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $cotizacion->fecha }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">${{ number_format($cotizacion->total, 2) }}</td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $colores = [
                                        'PENDIENTE' => 'text-amber-600',
                                        'ACEPTADA' => 'text-green-600',
                                        'RECHAZADA' => 'text-red-500',
                                        'VENCIDA' => 'text-gray-400',
                                        'CANCELADA' => 'text-gray-400',
                                    ];
                                @endphp
                                <span class="{{ $colores[$cotizacion->estado] ?? 'text-gray-500' }}">
                                    {{ $cotizacion->estado }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('comercial.cotizaciones.edit', $cotizacion) }}" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay cotizaciones registradas.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $cotizaciones->links() }}
        </div>
    </div>
</x-app-layout>