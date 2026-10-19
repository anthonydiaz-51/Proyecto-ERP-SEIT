<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Ventas</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6">

        <form method="GET" action="{{ route('comercial.ventas.index') }}"
              class="bg-white shadow rounded-lg p-4 mb-6 flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Origen</label>
                <select name="origen" class="mt-1 block rounded-md border-gray-300 text-sm">
                    <option value="todas" {{ $origen == 'todas' ? 'selected' : '' }}>Todas</option>
                    <option value="cotizaciones" {{ $origen == 'cotizaciones' ? 'selected' : '' }}>Cotizaciones aceptadas</option>
                    <option value="ordenes" {{ $origen == 'ordenes' ? 'selected' : '' }}>Órdenes entregadas</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Desde</label>
                <input type="date" name="desde" value="{{ $desde }}"
                       class="mt-1 block rounded-md border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Hasta</label>
                <input type="date" name="hasta" value="{{ $hasta }}"
                       class="mt-1 block rounded-md border-gray-300 text-sm">
            </div>
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                    Filtrar
                </button>
                <a href="{{ route('comercial.ventas.index') }}" class="px-4 py-2 text-sm text-gray-600">Limpiar</a>
            </div>
        </form>

        <p class="text-xs text-gray-500 mb-6">
            Una cotización aceptada deja de aparecer aquí cuando se genera su orden de servicio; a partir de ahí
            la venta se refleja en las órdenes entregadas. Los totales no se suman porque incluyen IVA de forma distinta.
        </p>

        @if($origen !== 'ordenes')
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-medium text-gray-800">Cotizaciones aceptadas sin orden</h3>
                    <span class="text-sm text-gray-700">Total: <strong>${{ number_format($totalCotizaciones, 2) }}</strong></span>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($cotizaciones as $cotizacion)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $cotizacion->folio }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $cotizacion->cliente->nombre ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $cotizacion->fecha }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">${{ number_format($cotizacion->total, 2) }}</td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="{{ route('comercial.cotizaciones.edit', $cotizacion) }}" class="text-indigo-600 hover:underline">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay cotizaciones aceptadas en este periodo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif

                @if($origen !== 'cotizaciones')
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-medium text-gray-800">Órdenes de servicio entregadas</h3>
                    <span class="text-sm text-gray-700">
                        Total: <strong>${{ number_format($totalOrdenes, 2) }}</strong>
                        · Cobrado: <strong>${{ number_format($totalCobrado, 2) }}</strong>
                    </span>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entrega</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Costo total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pagado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Saldo</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($ordenes as $orden)
                            @php
                                $pagado = $orden->pagos_sum_monto ?? 0;
                                $saldo = ($orden->costo_total ?? 0) - $pagado;
                            @endphp
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $orden->folio }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $orden->cliente->nombre ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $orden->fecha_entrega ?? '—' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">${{ number_format($orden->costo_total, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">${{ number_format($pagado, 2) }}</td>
                                <td class="px-6 py-4 text-sm text-right {{ $saldo > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    ${{ number_format($saldo, 2) }}
                                </td>
                                <td class="px-6 py-4 text-right text-sm space-x-3">
                                    @if($saldo > 0)
                                        <a href="{{ route('finanzas.pagos.create', ['orden_id' => $orden->id]) }}" class="text-indigo-600 hover:underline">Registrar pago</a>
                                    @endif
                                    <a href="{{ route('sistemas.ordenes.edit', $orden) }}" class="text-gray-500 hover:underline">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay órdenes entregadas en este periodo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>