<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Compra recibida</p>
                <h1 class="mt-1 text-2xl font-semibold text-white">Compra #{{ str_pad((string) $compra->id, 6, '0', STR_PAD_LEFT) }}</h1>
            </div>
            <a href="{{ route('compras.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-white hover:bg-white/5">← Regresar a compras</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-6xl space-y-6">
        @if(session('success'))<div class="rounded-lg border border-[#00A8FF]/30 bg-[#00A8FF]/10 px-4 py-3 text-sm text-white" role="status">{{ session('success') }}</div>@endif

        <section class="grid gap-4 md:grid-cols-3">
            <div class="rounded-xl border border-white/10 bg-[#111820] p-5 md:col-span-2">
                <p class="text-xs font-bold uppercase tracking-wide text-[#00A8FF]">Proveedor</p>
                <h2 class="mt-2 text-lg font-semibold text-white">{{ $compra->proveedor?->nombre ?? 'Proveedor eliminado' }}</h2>
                @if($compra->proveedor?->razon_social)<p class="mt-1 text-sm text-[#a7b4c1]">{{ $compra->proveedor->razon_social }}</p>@endif
                <div class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                    <p class="text-[#a7b4c1]">RFC: <span class="text-white">{{ $compra->proveedor?->rfc ?: '—' }}</span></p>
                    <p class="text-[#a7b4c1]">Contacto: <span class="text-white">{{ $compra->proveedor?->contacto ?: '—' }}</span></p>
                    <p class="text-[#a7b4c1]">Teléfono: <span class="text-white">{{ $compra->proveedor?->telefono ?: '—' }}</span></p>
                    <p class="text-[#a7b4c1]">Correo: <span class="text-white">{{ $compra->proveedor?->email ?: '—' }}</span></p>
                </div>
            </div>
            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-5">
                <p class="text-xs font-bold uppercase tracking-wide text-[#80d6ff]">Datos de recepción</p>
                <p class="mt-3 text-sm text-[#a7b4c1]">Fecha</p><p class="font-semibold text-white">{{ $compra->fecha?->format('d/m/Y') }}</p>
                <p class="mt-3 text-sm text-[#a7b4c1]">Referencia del proveedor</p><p class="font-semibold text-white">{{ $compra->referencia_proveedor ?: '—' }}</p>
                <p class="mt-3 text-sm text-[#a7b4c1]">Registró</p><p class="font-semibold text-white">{{ $compra->usuario?->nombre ?? 'Usuario eliminado' }}</p>
            </div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-white/10 bg-[#111820]">
            <div class="border-b border-white/10 px-5 py-4"><h2 class="font-semibold text-white">Detalle de productos recibidos</h2><p class="mt-1 text-xs text-[#81909e]">La existencia se actualizó al guardar esta compra.</p></div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/[0.03]"><tr>
                        <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Producto</th>
                        <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Cantidad</th>
                        <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Costo unitario</th>
                        <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Ubicación</th>
                        <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Importe</th>
                    </tr></thead>
                    <tbody class="divide-y divide-white/[0.06]">
                        @foreach($compra->detalles as $detalle)
                            <tr>
                                <td class="px-5 py-4"><p class="text-sm font-semibold text-white">{{ $detalle->producto?->nombre ?? 'Producto eliminado' }}</p><p class="mt-1 text-xs text-[#81909e]">{{ $detalle->producto?->codigo ?: 'Sin código' }}</p></td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm text-white">{{ number_format((float) $detalle->cantidad, 2) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm text-[#c7d0d9]">${{ number_format((float) $detalle->precio_unitario, 2) }}</td>
                                <td class="px-5 py-4 text-sm text-[#c7d0d9]">{{ $detalle->ubicacion ?: '—' }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-semibold text-white">${{ number_format((float) $detalle->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ml-auto max-w-sm space-y-2 border-t border-white/10 p-5 text-sm">
                <div class="flex justify-between text-[#a7b4c1]"><span>Subtotal</span><span>${{ number_format((float) $compra->subtotal, 2) }}</span></div>
                <div class="flex justify-between text-[#a7b4c1]"><span>Impuesto ({{ number_format((float) $compra->tasa_impuesto, 2) }}%)</span><span>${{ number_format((float) $compra->impuestos, 2) }}</span></div>
                <div class="flex justify-between border-t border-white/10 pt-2 text-base font-bold text-white"><span>Total</span><span class="text-[#00A8FF]">${{ number_format((float) $compra->total, 2) }}</span></div>
            </div>
            @if($compra->observaciones)<div class="border-t border-white/10 px-5 py-4"><p class="text-xs font-semibold uppercase tracking-wide text-[#81909e]">Observaciones</p><p class="mt-1 whitespace-pre-line text-sm text-[#c7d0d9]">{{ $compra->observaciones }}</p></div>@endif
        </section>
    </div>
</x-app-layout>
