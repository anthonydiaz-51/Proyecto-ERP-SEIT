<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Editar pago</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('finanzas.pagos.update', $pago) }}">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Orden de servicio</label>
                    <select name="orden_id" class="mt-1 block w-full rounded-md border-gray-300">
                        @foreach($ordenes as $orden)
                            @php
                                $saldo = ($orden->costo_total ?? 0) - ($orden->pagos_sum_monto ?? 0);
                            @endphp
                            <option value="{{ $orden->id }}"
                                {{ old('orden_id', $pago->orden_id) == $orden->id ? 'selected' : '' }}>
                                {{ $orden->folio }} — {{ $orden->cliente->nombre ?? '—' }} — Saldo ${{ number_format($saldo, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('orden_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha y hora</label>
                        <input type="datetime-local" name="fecha"
                               value="{{ old('fecha', \Carbon\Carbon::parse($pago->fecha)->format('Y-m-d\TH:i')) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('fecha') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Monto</label>
                        <input type="number" step="0.01" min="0.01" name="monto" value="{{ old('monto', $pago->monto) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('monto') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Método de pago</label>
                        <select name="metodo_pago" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($metodos as $metodo)
                                <option value="{{ $metodo }}" {{ old('metodo_pago', $pago->metodo_pago) == $metodo ? 'selected' : '' }}>
                                    {{ $metodo }}
                                </option>
                            @endforeach
                        </select>
                        @error('metodo_pago') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Referencia (opcional)</label>
                        <input type="text" name="referencia" value="{{ old('referencia', $pago->referencia) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('referencia') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('observaciones', $pago->observaciones) }}</textarea>
                </div>

                <p class="text-xs text-gray-500 mb-6">
                    Registrado por: {{ $pago->usuario->nombre ?? '—' }} {{ $pago->usuario->apellido ?? '' }}
                </p>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('finanzas.pagos.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>