<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Abastecimiento SEIT</p>
            <h1 class="mt-1 text-2xl font-semibold text-white">Registrar compra y recepción</h1>
        </div>
    </x-slot>

    <div class="mx-auto max-w-5xl">
        @if($errors->any())
            <div class="mb-5 rounded-xl border border-[#FF2B2B]/30 bg-[#FF2B2B]/10 p-4 text-sm text-[#ffb2b2]">
                <p class="font-semibold">Revisa los datos del formulario:</p>
                <ul class="mt-2 list-inside list-disc space-y-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div x-data="{
            productos: @js($productos->map(fn ($producto) => ['id' => $producto->id, 'codigo' => $producto->codigo, 'nombre' => $producto->nombre, 'precio' => (float) ($producto->precio_compra ?? 0)])->values()),
            lineas: @js(old('lineas', [['producto_id' => '', 'cantidad' => 1, 'precio_unitario' => 0, 'ubicacion' => '']])),
            tasaImpuesto: Number(@js(old('tasa_impuesto', 16))),
            agregarLinea() { this.lineas.push({ producto_id: '', cantidad: 1, precio_unitario: 0, ubicacion: '' }); },
            quitarLinea(indice) { if (this.lineas.length > 1) this.lineas.splice(indice, 1); },
            actualizarPrecio(linea) {
                const producto = this.productos.find(item => String(item.id) === String(linea.producto_id));
                if (producto) linea.precio_unitario = producto.precio;
            },
            get subtotal() { return this.lineas.reduce((acum, linea) => acum + (Number(linea.cantidad || 0) * Number(linea.precio_unitario || 0)), 0); },
            get impuestos() { return this.subtotal * Number(this.tasaImpuesto || 0) / 100; },
            get total() { return this.subtotal + this.impuestos; },
            dinero(valor) { return new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(Number(valor || 0)); }
        }" class="space-y-6">
            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-4 text-sm text-[#c7d0d9]">
                Al guardar, cada producto se recibirá en inventario, se actualizará su último costo de compra y se registrará una entrada en el historial de movimientos.
            </div>

            @if($proveedores->isEmpty())
                <div class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-4 text-sm text-amber-200">Registra primero un proveedor activo para poder capturar una compra.</div>
            @endif
            @if($productos->isEmpty())
                <div class="rounded-xl border border-amber-400/30 bg-amber-400/10 p-4 text-sm text-amber-200">No hay productos activos en el catálogo. Agrega productos antes de recibir compras.</div>
            @endif

            <form method="POST" action="{{ route('compras.store') }}" class="space-y-6 rounded-2xl border border-[#00A8FF]/20 bg-[#111820] p-5 shadow-xl sm:p-8">
                @csrf

                <section>
                    <h2 class="text-sm font-bold uppercase tracking-wide text-[#00A8FF]">Datos de la compra</h2>
                    <div class="mt-4 grid gap-5 sm:grid-cols-2">
                        <div>
                            <label for="proveedor_id" class="mb-2 block text-sm font-medium text-white">Proveedor <span class="text-[#FF2B2B]">*</span></label>
                            <select id="proveedor_id" name="proveedor_id" required class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                                <option value="">Selecciona un proveedor</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" @selected((string) old('proveedor_id') === (string) $proveedor->id)>{{ $proveedor->nombre }}{{ $proveedor->rfc ? ' · '.$proveedor->rfc : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="fecha" class="mb-2 block text-sm font-medium text-white">Fecha de recepción <span class="text-[#FF2B2B]">*</span></label>
                            <input id="fecha" name="fecha" type="date" required value="{{ old('fecha', now()->toDateString()) }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                        </div>
                        <div>
                            <label for="referencia_proveedor" class="mb-2 block text-sm font-medium text-white">Referencia o folio del proveedor</label>
                            <input id="referencia_proveedor" name="referencia_proveedor" maxlength="100" value="{{ old('referencia_proveedor') }}" placeholder="Folio de remisión o factura" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                        </div>
                        <div>
                            <label for="tasa_impuesto" class="mb-2 block text-sm font-medium text-white">Impuesto (%) <span class="text-[#FF2B2B]">*</span></label>
                            <input id="tasa_impuesto" name="tasa_impuesto" type="number" min="0" max="100" step="0.01" required x-model.number="tasaImpuesto" value="{{ old('tasa_impuesto', 16) }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                        </div>
                    </div>
                </section>

                <section class="border-t border-white/10 pt-6">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div><h2 class="text-sm font-bold uppercase tracking-wide text-[#00A8FF]">Productos recibidos</h2><p class="mt-1 text-xs text-[#81909e]">El costo unitario queda como el último costo de compra del producto.</p></div>
                        <button type="button" @click="agregarLinea()" :disabled="productos.length === 0" class="rounded-lg border border-[#00A8FF]/30 px-3 py-2 text-xs font-bold text-[#00A8FF] transition hover:bg-[#00A8FF]/10 disabled:opacity-50">+ Agregar producto</button>
                    </div>

                    <div class="mt-4 space-y-3">
                        <template x-for="(linea, indice) in lineas" :key="indice">
                            <div class="grid gap-3 rounded-xl border border-white/10 bg-[#0d1319] p-3 sm:grid-cols-2 lg:grid-cols-[minmax(0,2fr)_minmax(90px,.7fr)_minmax(125px,1fr)_minmax(130px,1fr)_minmax(130px,1fr)_auto] lg:items-end">
                                <div class="sm:col-span-2 lg:col-span-1">
                                    <label class="mb-1.5 block text-xs font-medium text-[#a7b4c1]">Producto</label>
                                    <select :name="`lineas[${indice}][producto_id]`" x-model="linea.producto_id" @change="actualizarPrecio(linea)" required class="w-full rounded-lg border border-white/10 bg-[#111820] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                                        <option value="">Selecciona un producto</option>
                                        <template x-for="producto in productos" :key="producto.id"><option :value="producto.id" x-text="`${producto.nombre}${producto.codigo ? ' · '+producto.codigo : ''}`"></option></template>
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-[#a7b4c1]">Cantidad</label>
                                    <input type="number" min="0.01" max="99999999.99" step="0.01" :name="`lineas[${indice}][cantidad]`" x-model.number="linea.cantidad" required class="w-full rounded-lg border border-white/10 bg-[#111820] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-[#a7b4c1]">Costo unitario</label>
                                    <input type="number" min="0" max="99999999.99" step="0.01" :name="`lineas[${indice}][precio_unitario]`" x-model.number="linea.precio_unitario" required class="w-full rounded-lg border border-white/10 bg-[#111820] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                                </div>
                                <div>
                                    <label class="mb-1.5 block text-xs font-medium text-[#a7b4c1]">Ubicación</label>
                                    <input type="text" maxlength="100" :name="`lineas[${indice}][ubicacion]`" x-model="linea.ubicacion" placeholder="Opcional" class="w-full rounded-lg border border-white/10 bg-[#111820] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none">
                                </div>
                                <div class="flex items-end justify-between gap-3 lg:block">
                                    <div><p class="text-xs text-[#81909e]">Importe</p><p class="mt-1 text-sm font-bold text-white" x-text="dinero(Number(linea.cantidad || 0) * Number(linea.precio_unitario || 0))"></p></div>
                                    <button type="button" @click="quitarLinea(indice)" :disabled="lineas.length <= 1" aria-label="Quitar producto" class="rounded-lg px-2 py-2 text-lg leading-none text-[#ff7373] hover:bg-[#FF2B2B]/10 disabled:cursor-not-allowed disabled:opacity-30">&times;</button>
                                </div>
                            </div>
                        </template>
                    </div>
                    @error('lineas')<p class="mt-3 text-sm text-[#ff7373]">{{ $message }}</p>@enderror
                </section>

                <section class="border-t border-white/10 pt-6">
                    <label for="observaciones" class="mb-2 block text-sm font-medium text-white">Observaciones</label>
                    <textarea id="observaciones" name="observaciones" rows="3" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">{{ old('observaciones') }}</textarea>
                </section>

                <div class="ml-auto max-w-sm space-y-2 border-t border-white/10 pt-5 text-sm">
                    <div class="flex justify-between text-[#a7b4c1]"><span>Subtotal</span><span x-text="dinero(subtotal)"></span></div>
                    <div class="flex justify-between text-[#a7b4c1]"><span>Impuestos</span><span x-text="dinero(impuestos)"></span></div>
                    <div class="flex justify-between border-t border-white/10 pt-2 text-base font-bold text-white"><span>Total de la compra</span><span class="text-[#00A8FF]" x-text="dinero(total)"></span></div>
                </div>

                <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">
                    <a href="{{ route('compras.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Cancelar</a>
                    <button type="submit" @disabled($proveedores->isEmpty() || $productos->isEmpty()) class="rounded-lg bg-[#FF2B2B] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#e51f25] disabled:cursor-not-allowed disabled:opacity-50">Guardar y recibir productos</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
