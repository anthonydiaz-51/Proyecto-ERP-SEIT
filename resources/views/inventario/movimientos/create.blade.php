<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div><p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Trazabilidad de almacén</p><h1 class="mt-1 text-2xl font-semibold text-white">Registrar movimiento</h1></div>
            <a href="{{ route('inventario.movimientos.index') }}" class="text-sm font-semibold text-[#a7b4c1] hover:text-white">← Historial de movimientos</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="{{ route('inventario.movimientos.store') }}" class="space-y-6 rounded-2xl border border-[#00A8FF]/20 bg-[#111820] p-5 shadow-xl sm:p-8">
            @csrf

            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-4">
                <p class="text-sm font-semibold text-white">El movimiento actualiza la existencia y queda guardado en el historial.</p>
                <p class="mt-1 text-xs leading-5 text-[#a7b4c1]">Entrada suma unidades, salida las resta. Ajuste establece la existencia final indicada.</p>
            </div>

            <div>
                <label for="producto_id" class="mb-2 block text-sm font-medium text-white">Producto <span class="text-[#FF2B2B]">*</span></label>
                <select id="producto_id" name="producto_id" required class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <option value="">Selecciona un producto</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" data-existencia="{{ (float) ($producto->inventario?->existencia ?? 0) }}" data-ubicacion="{{ $producto->inventario?->ubicacion }}" @selected((string) old('producto_id', $productoSeleccionado) === (string) $producto->id)>
                            {{ $producto->nombre }} · {{ $producto->codigo ?: 'Sin código' }} · Stock: {{ number_format((float) ($producto->inventario?->existencia ?? 0), 2) }}
                        </option>
                    @endforeach
                </select>
                @error('producto_id')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
                @if($productos->isEmpty())<p class="mt-2 text-xs text-amber-300">No hay productos activos. Agrega primero un producto al inventario.</p>@endif
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="tipo" class="mb-2 block text-sm font-medium text-white">Tipo de movimiento <span class="text-[#FF2B2B]">*</span></label>
                    <select id="tipo" name="tipo" required class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                        <option value="ENTRADA" @selected(old('tipo', 'ENTRADA') === 'ENTRADA')>Entrada · agregar unidades</option>
                        <option value="SALIDA" @selected(old('tipo') === 'SALIDA')>Salida · retirar unidades</option>
                        <option value="AJUSTE" @selected(old('tipo') === 'AJUSTE')>Ajuste · definir existencia final</option>
                    </select>
                    @error('tipo')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label id="cantidad-label" for="cantidad" class="mb-2 block text-sm font-medium text-white">Cantidad de unidades <span class="text-[#FF2B2B]">*</span></label>
                    <input id="cantidad" name="cantidad" type="number" min="0" step="0.01" max="99999999.99" required value="{{ old('cantidad') }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <p id="cantidad-ayuda" class="mt-1 text-xs text-[#81909e]">La entrada se sumará a la existencia actual.</p>
                    @error('cantidad')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="referencia" class="mb-2 block text-sm font-medium text-white">Referencia</label>
                    <input id="referencia" name="referencia" type="text" maxlength="100" value="{{ old('referencia') }}" placeholder="Folio, factura, orden..." class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    @error('referencia')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="ubicacion" class="mb-2 block text-sm font-medium text-white">Ubicación</label>
                    <input id="ubicacion" name="ubicacion" type="text" maxlength="100" value="{{ old('ubicacion') }}" placeholder="Se conserva si se deja vacío" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    @error('ubicacion')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="motivo" class="mb-2 block text-sm font-medium text-white">Motivo / observaciones</label>
                <textarea id="motivo" name="motivo" rows="3" maxlength="255" placeholder="Describe brevemente el movimiento" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">{{ old('motivo') }}</textarea>
                @error('motivo')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
            </div>

            <div class="flex justify-end gap-3 border-t border-white/10 pt-5">
                <a href="{{ route('inventario.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Cancelar</a>
                <button type="submit" @disabled($productos->isEmpty()) class="rounded-lg bg-[#FF2B2B] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#e51f25] disabled:cursor-not-allowed disabled:opacity-50">Aplicar movimiento</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tipo = document.getElementById('tipo');
            const cantidad = document.getElementById('cantidad');
            const ayuda = document.getElementById('cantidad-ayuda');
            const etiqueta = document.getElementById('cantidad-label');
            const ubicacion = document.getElementById('ubicacion');
            const producto = document.getElementById('producto_id');

            const actualizar = () => {
                if (tipo.value === 'AJUSTE') {
                    etiqueta.firstChild.textContent = 'Existencia final ';
                    cantidad.min = '0';
                    ayuda.textContent = 'Escribe el total que debe quedar después del ajuste.';
                } else {
                    etiqueta.firstChild.textContent = 'Cantidad de unidades ';
                    cantidad.min = '0.01';
                    ayuda.textContent = tipo.value === 'SALIDA'
                        ? 'La cantidad se descontará de la existencia actual.'
                        : 'La cantidad se sumará a la existencia actual.';
                }
            };

            producto.addEventListener('change', () => {
                const option = producto.selectedOptions[0];
                if (option?.dataset.ubicacion && !ubicacion.value) ubicacion.value = option.dataset.ubicacion;
            });
            tipo.addEventListener('change', actualizar);
            actualizar();
        });
    </script>
</x-app-layout>
