<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Pagos</h2>
            <a href="{{ route('finanzas.pagos.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Registrar pago
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referencia</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registró</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($pagos as $pago)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->fecha }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $pago->orden->folio ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->orden->cliente->nombre ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->metodo_pago }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->referencia ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900 text-right">${{ number_format($pago->monto, 2) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $pago->usuario->nombre ?? '—' }}</td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('finanzas.pagos.edit', $pago) }}" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay pagos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $pagos->links() }}
        </div>
    </div>
</x-app-layout>