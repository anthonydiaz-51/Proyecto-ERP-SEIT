@php($editando = $producto !== null)

<form method="POST" action="{{ $editando ? route('inventario.productos.update', $producto) : route('inventario.productos.store') }}" class="space-y-6 rounded-2xl border border-[#00A8FF]/20 bg-[#111820] p-5 shadow-xl sm:p-8">
    @csrf
    @if($editando)
        @method('PUT')
    @endif

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="nombre" class="mb-2 block text-sm font-medium text-white">Nombre del producto <span class="text-[#FF2B2B]">*</span></label>
            <input id="nombre" name="nombre" type="text" maxlength="150" required value="{{ old('nombre', $producto?->nombre) }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
            @error('nombre')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="codigo" class="mb-2 block text-sm font-medium text-white">Código / SKU</label>
            <input id="codigo" name="codigo" type="text" maxlength="50" value="{{ old('codigo', $producto?->codigo) }}" placeholder="Ej. SEIT-PC-001" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
            @error('codigo')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="categoria_id" class="mb-2 block text-sm font-medium text-white">Categoría</label>
            <select id="categoria_id" name="categoria_id" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                <option value="">Sin categoría</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected((string) old('categoria_id', $producto?->categoria_id) === (string) $categoria->id)>{{ $categoria->nombre }}</option>
                @endforeach
            </select>
            @error('categoria_id')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="ubicacion" class="mb-2 block text-sm font-medium text-white">Ubicación en almacén</label>
            <input id="ubicacion" name="ubicacion" type="text" maxlength="100" value="{{ old('ubicacion', $producto?->inventario?->ubicacion) }}" placeholder="Ej. Estante A · Nivel 2" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
            @error('ubicacion')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="precio_compra" class="mb-2 block text-sm font-medium text-white">Precio de compra</label>
            <div class="flex items-center rounded-lg border border-white/10 bg-[#0b1015] px-3 focus-within:border-[#00A8FF]"><span class="mr-2 text-sm text-[#81909e]">$</span><input id="precio_compra" name="precio_compra" type="number" min="0" step="0.01" value="{{ old('precio_compra', $producto?->precio_compra) }}" class="w-full border-0 bg-transparent px-0 py-2.5 text-sm text-white focus:outline-none focus:ring-0"></div>
            @error('precio_compra')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="precio_venta" class="mb-2 block text-sm font-medium text-white">Precio de venta</label>
            <div class="flex items-center rounded-lg border border-white/10 bg-[#0b1015] px-3 focus-within:border-[#00A8FF]"><span class="mr-2 text-sm text-[#81909e]">$</span><input id="precio_venta" name="precio_venta" type="number" min="0" step="0.01" value="{{ old('precio_venta', $producto?->precio_venta) }}" class="w-full border-0 bg-transparent px-0 py-2.5 text-sm text-white focus:outline-none focus:ring-0"></div>
            @error('precio_venta')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="stock_minimo" class="mb-2 block text-sm font-medium text-white">Nivel mínimo de stock</label>
            <input id="stock_minimo" name="stock_minimo" type="number" min="0" step="1" value="{{ old('stock_minimo', $producto?->stock_minimo ?? 0) }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
            @error('stock_minimo')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
        </div>

        @if(!$editando)
            <div>
                <label for="existencia_inicial" class="mb-2 block text-sm font-medium text-white">Existencia inicial</label>
                <input id="existencia_inicial" name="existencia_inicial" type="number" min="0" step="0.01" value="{{ old('existencia_inicial', '0') }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <p class="mt-1 text-xs text-[#81909e]">Si agregas unidades, se registrará una entrada inicial en el historial.</p>
                @error('existencia_inicial')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
            </div>
        @else
            <div class="rounded-lg border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-3">
                <p class="text-xs uppercase tracking-wide text-[#81909e]">Existencia actual</p>
                <p class="mt-1 text-lg font-bold text-[#00A8FF]">{{ number_format((float) ($producto->inventario?->existencia ?? 0), 2) }}</p>
                <p class="mt-1 text-xs text-[#a7b4c1]">Registra entradas, salidas o ajustes desde el historial para conservar trazabilidad.</p>
            </div>
        @endif
    </div>

    @if(!$editando)
        <div>
            <label for="motivo_inicial" class="mb-2 block text-sm font-medium text-white">Nota de existencia inicial</label>
            <input id="motivo_inicial" name="motivo_inicial" type="text" maxlength="255" value="{{ old('motivo_inicial') }}" placeholder="Opcional: compra inicial, inventario físico..." class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
        </div>
    @else
        <div class="flex items-center justify-between gap-4 rounded-lg border border-white/10 bg-black/10 p-4">
            <div><p class="text-sm font-semibold text-white">Control de stock</p><p class="mt-1 text-xs text-[#a7b4c1]">Los cambios de existencia deben registrarse como movimiento.</p></div>
            <a href="{{ route('inventario.movimientos.create', ['producto_id' => $producto->id]) }}" class="shrink-0 rounded-lg bg-[#00A8FF]/10 px-3 py-2 text-xs font-bold text-[#00A8FF] hover:bg-[#00A8FF] hover:text-[#0D0D0D]">Mover stock</a>
        </div>
        <label class="inline-flex items-center gap-2 text-sm text-white">
            <input type="hidden" name="activo" value="0">
            <input type="checkbox" name="activo" value="1" @checked(old('activo', $producto->activo)) class="rounded border-white/20 bg-[#0b1015] text-[#00A8FF] focus:ring-[#00A8FF]">
            Producto activo en el catálogo
        </label>
        @error('activo')<p class="text-xs text-[#ff7373]">{{ $message }}</p>@enderror
    @endif

    <div>
        <label for="descripcion" class="mb-2 block text-sm font-medium text-white">Descripción</label>
        <textarea id="descripcion" name="descripcion" rows="4" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]" placeholder="Características o detalles del producto">{{ old('descripcion', $producto?->descripcion) }}</textarea>
        @error('descripcion')<p class="mt-1 text-xs text-[#ff7373]">{{ $message }}</p>@enderror
    </div>

    <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">
        <a href="{{ route('inventario.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Cancelar</a>
        <button type="submit" class="rounded-lg bg-[#FF2B2B] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#e51f25]">{{ $editando ? 'Guardar cambios' : 'Guardar producto' }}</button>
    </div>
</form>

@if($editando)
    <form method="POST" action="{{ route('inventario.productos.destroy', $producto) }}" class="mt-4 flex justify-end" onsubmit="return confirm('¿Desactivar este producto? Se conservará su historial de inventario.');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-sm font-semibold text-[#ff7373] hover:underline">Desactivar producto</button>
    </form>
@endif
