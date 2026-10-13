<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar cotización — {{ $cotizacion->folio }}</h2>
    </x-slot>

    <div
        x-data="{
            lineas: {{ $cotizacion->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'tipo_descuento' => 'FIJO',
                'descuento' => $d->descuento,
            ])->values() }},

            servicios: @js($servicios->map(fn($servicio) => [
                'id' => $servicio->id,
                'nombre' => $servicio->servicio,
                'precio' => $servicio->precio_base
            ])->values()),

            lineasOriginales: {{ $cotizacion->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'tipo_descuento' => 'FIJO',
                'descuento' => $d->descuento,
            ])->values() }},

            agregarLinea() {
                this.lineas.push({
                    servicio_id: '',
                    cantidad: 1,
                    precio_unitario: 0,
                    tipo_descuento: 'FIJO',
                    descuento: 0
                });
            },

            quitarLinea(index) {
                if (this.lineas.length > 1) {
                    this.lineas.splice(index, 1);
                }
            },

            autocompletarPrecio(index) {
                const servicioId = this.lineas[index].servicio_id;
                const servicio = this.servicios.find(
                    item => item.id == servicioId
                );

                this.lineas[index].precio_unitario = servicio
                    ? servicio.precio
                    : 0;
            },

            montoDescuento(linea) {
                const cantidad = Number(linea.cantidad) || 0;
                const precio = Number(linea.precio_unitario) || 0;
                const descuento = Number(linea.descuento) || 0;
                const importeBruto = cantidad * precio;

                return linea.tipo_descuento === 'PORCENTAJE'
                    ? importeBruto * descuento / 100
                    : descuento;
            },

            subtotalLinea(linea) {
                const cantidad = Number(linea.cantidad) || 0;
                const precio = Number(linea.precio_unitario) || 0;
                const importeBruto = cantidad * precio;

                return importeBruto - this.montoDescuento(linea);
            },

            get subtotal() {
                return this.lineas.reduce(
                    (acumulado, linea) =>
                        acumulado + this.subtotalLinea(linea),
                    0
                );
            },

            get impuestos() {
                return this.subtotal * 0.16;
            },

            get total() {
                return this.subtotal + this.impuestos;
            },

            limpiarFormulario() {
                this.$nextTick(() => {
                    this.lineas = JSON.parse(JSON.stringify(this.lineasOriginales));
                });
            }
        }"
        class="max-w-4xl mx-auto py-6"
    >
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('comercial.cotizaciones.update', $cotizacion) }}" @reset="limpiarFormulario()">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id', $cotizacion->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="fecha" value="{{ old('fecha', $cotizacion->fecha) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        @error('fecha') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach(['PENDIENTE', 'ACEPTADA', 'RECHAZADA', 'VENCIDA', 'CANCELADA'] as $estado)
                                <option value="{{ $estado }}" {{ old('estado', $cotizacion->estado) == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Vigencia (opcional)</label>
                    <input type="date" name="vigencia" value="{{ old('vigencia', $cotizacion->vigencia) }}"
                           class="mt-1 block w-48 rounded-md border-gray-300">
                </div>

                <h3 class="font-medium text-gray-700 mb-2">Servicios cotizados</h3>

                <template x-for="(linea, index) in lineas" :key="index">
                    <div class="grid grid-cols-12 gap-2 mb-2 items-start">
                        <div class="col-span-3">
                            <select :name="'lineas[' + index + '][servicio_id]'" x-model="linea.servicio_id"
                                    @change="autocompletarPrecio(index)"
                                    class="block w-full rounded-md border-gray-300 text-sm">
                                <option value="">-- Servicio --</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->servicio }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="1.00" min="0" :name="'lineas[' + index + '][cantidad]'"
                                   x-model.number="linea.cantidad" placeholder="Cantidad"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="0.01" min="0" :name="'lineas[' + index + '][precio_unitario]'"
                                   x-model.number="linea.precio_unitario" placeholder="Precio"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <select :name="'lineas[' + index + '][tipo_descuento]'" x-model="linea.tipo_descuento"
                                    class="block w-full rounded-md border-gray-300 text-sm">
                                <option value="FIJO">Fijo ($)</option>
                                <option value="PORCENTAJE">Porcentaje (%)</option>
                            </select>
                        </div>
                        <div class="col-span-3">
                            <input type="number" step="1.00" min="0"
                                   :max="linea.tipo_descuento === 'PORCENTAJE' ? 100 : null"
                                   :name="'lineas[' + index + '][descuento]'"
                                   x-model.number="linea.descuento"
                                   :placeholder="linea.tipo_descuento === 'PORCENTAJE' ? '%' : '$'"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        
                            <button type="button" @click="quitarLinea(index)" class="text-red-500 text-sm" aria-label="Quitar línea">✕</button>
                        </div>
                    </div>
                </template>

                <button type="button" @click="agregarLinea()" class="text-indigo-600 text-sm mb-6">
                    + Agregar línea
                </button>
                @error('lineas') <p class="text-red-500 text-sm mb-4">{{ $message }}</p> @enderror

                <div class="border-t pt-4 mb-6 text-right text-sm text-gray-700 space-y-1">
                    <p>Subtotal: $<span x-text="subtotal.toFixed(2)"></span></p>
                    <p>Impuestos (16%): $<span x-text="impuestos.toFixed(2)"></span></p>
                    <p class="font-semibold text-base">Total: $<span x-text="total.toFixed(2)"></span></p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('observaciones', $cotizacion->observaciones) }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset" class="px-4 py-2 text-sm text-gray-600">
                        Limpiar
                    </button>
                    <a href="{{ route('comercial.cotizaciones.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('comercial.cotizaciones.destroy', $cotizacion) }}"
                  onsubmit="return confirm('¿Cancelar esta cotización?');" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 text-sm hover:underline">Cancelar cotización</button>
            </form>
        </div>
    </div>
</x-app-layout>