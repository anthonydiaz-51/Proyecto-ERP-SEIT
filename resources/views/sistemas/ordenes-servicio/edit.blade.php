<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar orden — {{ $orden->folio }}</h2>
    </x-slot>

    <div
        x-data="{
            lineas: {{ $orden->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'descuento' => $d->descuento,
            ])->values() }},
            lineasOriginales: {{ $orden->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'descuento' => $d->descuento,
            ])->values() }},
            servicios: @js($servicios->map(fn($s) => ['id' => $s->id, 'nombre' => $s->servicio, 'precio' => $s->precio_base])->values()),
            agregarLinea() {
                this.lineas.push({ servicio_id: '', cantidad: 1, precio_unitario: 0, descuento: 0 });
            },
            quitarLinea(index) {
                this.lineas.splice(index, 1);
            },
            autocompletarPrecio(index) {
                const servicio = this.servicios.find(s => s.id == this.lineas[index].servicio_id);
                this.lineas[index].precio_unitario = servicio ? servicio.precio : 0;
            },
            subtotalLinea(linea) {
                return (linea.cantidad * linea.precio_unitario) - (linea.descuento || 0);
            },
            get costoTotal() {
                return this.lineas.reduce((acc, l) => acc + this.subtotalLinea(l), 0);
            },
            limpiarFormulario() {
                this.$nextTick(() => { this.lineas = JSON.parse(JSON.stringify(this.lineasOriginales)); });
            }
        }"
        class="max-w-4xl mx-auto py-6"
    >
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('sistemas.ordenes.update', $orden) }}" @reset="limpiarFormulario()">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id', $orden->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Técnico asignado</label>
                        <select name="tecnico_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Sin asignar --</option>
                            @foreach($tecnicos as $tecnico)
                                <option value="{{ $tecnico->id }}" {{ old('tecnico_id', $orden->tecnico_id) == $tecnico->id ? 'selected' : '' }}>
                                    {{ $tecnico->nombre }} {{ $tecnico->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 block w-full rounded-md border-gray-300">
                            @foreach(['RECIBIDO','DIAGNOSTICO','COTIZACION','AUTORIZADO','EN_PROCESO','LISTO','ENTREGADO','CANCELADO'] as $estado)
                                <option value="{{ $estado }}" {{ old('estado', $orden->estado) == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de recepción</label>
                        <input type="date" name="fecha_recepcion" value="{{ old('fecha_recepcion', $orden->fecha_recepcion) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha compromiso</label>
                        <input type="date" name="fecha_compromiso" value="{{ old('fecha_compromiso', $orden->fecha_compromiso) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha entrega</label>
                        <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', $orden->fecha_entrega) }}"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Prioridad</label>
                    <select name="prioridad" class="mt-1 block w-48 rounded-md border-gray-300">
                        @foreach(['BAJA', 'MEDIA', 'ALTA', 'URGENTE'] as $prioridad)
                            <option value="{{ $prioridad }}" {{ old('prioridad', $orden->prioridad) == $prioridad ? 'selected' : '' }}>
                                {{ $prioridad }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Descripción de la falla</label>
                    <textarea name="descripcion_falla" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('descripcion_falla', $orden->descripcion_falla) }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                    <textarea name="diagnostico" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('diagnostico', $orden->diagnostico) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Solución</label>
                    <textarea name="solucion" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('solucion', $orden->solucion) }}</textarea>
                </div>

                <h3 class="font-medium text-gray-700 mb-2">Servicios realizados</h3>

                <template x-for="(linea, index) in lineas" :key="index">
                    <div class="grid grid-cols-12 gap-2 mb-2 items-start">
                        <div class="col-span-5">
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
                            <input type="number" step="1" min="0" :name="'lineas[' + index + '][cantidad]'"
                                   x-model.number="linea.cantidad" placeholder="Cantidad"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="0.01" min="0" :name="'lineas[' + index + '][precio_unitario]'"
                                   x-model.number="linea.precio_unitario" placeholder="Precio"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="0.01" min="0" :name="'lineas[' + index + '][descuento]'"
                                   x-model.number="linea.descuento" placeholder="Descuento"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-1">
                            <button type="button" @click="quitarLinea(index)" class="text-red-500 text-sm">✕</button>
                        </div>
                    </div>
                </template>

                <button type="button" @click="agregarLinea()" class="text-indigo-600 text-sm mb-6">
                    + Agregar servicio
                </button>

                <div class="border-t pt-4 mb-6 text-right text-sm text-gray-700">
                    <p class="font-semibold text-base">Costo total: $<span x-text="costoTotal.toFixed(2)"></span></p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="mt-1 block w-full rounded-md border-gray-300">{{ old('observaciones', $orden->observaciones) }}</textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset" class="px-4 py-2 text-sm text-gray-600">Limpiar</button>
                    <a href="{{ route('sistemas.ordenes.index') }}" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            <form method="POST" action="{{ route('sistemas.ordenes.destroy', $orden) }}"
                  onsubmit="return confirm('¿Cancelar esta orden de servicio?');" class="mt-4">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 text-sm hover:underline">Cancelar orden</button>
            </form>
        </div>
    </div>
</x-app-layout>

