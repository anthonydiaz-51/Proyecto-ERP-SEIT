<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Abastecimiento SEIT</p>
                <h1 class="mt-1 text-2xl font-semibold text-white">Compras y recepciones</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('compras.proveedores.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:border-[#00A8FF]/40 hover:bg-[#00A8FF]/10">Proveedores</a>
                <a href="{{ route('compras.create') }}" class="rounded-lg bg-[#FF2B2B] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#e51f25]">+ Registrar compra</a>
            </div>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6">
        @if(session('success'))
            <div class="rounded-lg border border-[#00A8FF]/30 bg-[#00A8FF]/10 px-4 py-3 text-sm text-white" role="status">{{ session('success') }}</div>
        @endif

        <section class="grid gap-3 sm:grid-cols-2">
            <div class="rounded-xl border border-white/10 bg-[#111820] p-4"><p class="text-xs text-[#a7b4c1]">Compras recibidas</p><p class="mt-1 text-2xl font-bold text-white">{{ number_format($totalCompras) }}</p></div>
            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-4"><p class="text-xs text-[#a7b4c1]">Importe registrado este mes</p><p class="mt-1 text-2xl font-bold text-[#00A8FF]">${{ number_format((float) $importeMes, 2) }}</p></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-white/10 bg-[#111820]">
            <form method="GET" action="{{ route('compras.index') }}" class="grid gap-3 border-b border-white/10 p-4 sm:grid-cols-[minmax(0,1fr)_190px_190px_auto_auto] sm:items-end">
                <div>
                    <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Buscar</label>
                    <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Proveedor, RFC o referencia" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                </div>
                <div>
                    <label for="desde" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Desde</label>
                    <input id="desde" type="date" name="desde" value="{{ request('desde') }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                </div>
                <div>
                    <label for="hasta" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Hasta</label>
                    <input id="hasta" type="date" name="hasta" value="{{ request('hasta') }}" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                </div>
                <button type="submit" class="rounded-lg bg-[#00A8FF] px-4 py-2.5 text-sm font-bold text-[#0D0D0D] transition hover:bg-[#008bd1]">Filtrar</button>
                <a href="{{ route('compras.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-center text-sm font-semibold text-[#a7b4c1] transition hover:bg-white/5">Limpiar</a>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/[0.03]">
                        <tr>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Compra</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Proveedor</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Fecha</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Productos</th>
                            <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Total</th>
                            <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.06]">
                        @forelse($compras as $compra)
                            <tr class="transition hover:bg-white/[0.025]">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <a href="{{ route('compras.show', $compra) }}" class="text-sm font-bold text-[#00A8FF] hover:underline">COMPRA #{{ str_pad((string) $compra->id, 6, '0', STR_PAD_LEFT) }}</a>
                                    <p class="mt-1 text-xs text-[#81909e]">{{ $compra->referencia_proveedor ?: 'Sin referencia externa' }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm text-white">
                                    <p class="font-semibold">{{ $compra->proveedor?->nombre ?? 'Proveedor eliminado' }}</p>
                                    <p class="mt-0.5 text-xs text-[#81909e]">{{ $compra->proveedor?->rfc ?: 'Sin RFC' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-[#c7d0d9]">{{ $compra->fecha?->format('d/m/Y') }}</td>
                                <td class="px-5 py-4 text-sm text-[#c7d0d9]">{{ number_format($compra->detalles_count) }} líneas</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-bold text-white">${{ number_format((float) $compra->total, 2) }}</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right"><a href="{{ route('compras.show', $compra) }}" class="text-sm font-semibold text-[#00A8FF] hover:underline">Ver detalle</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-14 text-center">
                                <p class="font-semibold text-white">Todavía no hay compras registradas</p>
                                <p class="mt-1 text-sm text-[#a7b4c1]">Registra una compra para recibir sus productos y actualizar existencias.</p>
                                <a href="{{ route('compras.create') }}" class="mt-4 inline-flex rounded-lg bg-[#FF2B2B] px-4 py-2 text-sm font-bold text-white hover:bg-[#e51f25]">Registrar compra</a>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-white/10 px-5 py-4">{{ $compras->links() }}</div>
        </section>
    </div>
</x-app-layout>
