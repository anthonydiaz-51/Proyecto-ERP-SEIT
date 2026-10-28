<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Compras SEIT</p>
                <h1 class="mt-1 text-2xl font-semibold text-white">Proveedores</h1>
            </div>
            <a href="{{ route('compras.proveedores.create') }}" class="rounded-lg bg-[#FF2B2B] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#e51f25]">+ Registrar proveedor</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl space-y-6">
        @if(session('success'))
            <div class="rounded-lg border border-[#00A8FF]/30 bg-[#00A8FF]/10 px-4 py-3 text-sm text-white" role="status">{{ session('success') }}</div>
        @endif

        <section class="grid gap-3 sm:grid-cols-3">
            <div class="rounded-xl border border-white/10 bg-[#111820] p-4"><p class="text-xs text-[#a7b4c1]">Registros de proveedor</p><p class="mt-1 text-2xl font-bold text-white">{{ number_format($totalProveedores) }}</p></div>
            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-4"><p class="text-xs text-[#a7b4c1]">Activos</p><p class="mt-1 text-2xl font-bold text-[#00A8FF]">{{ number_format($proveedoresActivos) }}</p></div>
            <div class="rounded-xl border border-white/10 bg-[#111820] p-4"><p class="text-xs text-[#a7b4c1]">Inactivos</p><p class="mt-1 text-2xl font-bold text-[#FF2B2B]">{{ number_format($proveedoresInactivos) }}</p></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-white/10 bg-[#111820]">
            <form method="GET" action="{{ route('compras.proveedores.index') }}" class="grid gap-3 border-b border-white/10 p-4 sm:grid-cols-[minmax(0,1fr)_220px_auto_auto] sm:items-end">
                <div>
                    <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Buscar proveedor</label>
                    <input id="q" type="search" name="q" value="{{ request('q') }}" placeholder="Nombre, RFC, contacto o correo" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                </div>
                <div>
                    <label for="estado" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Estado</label>
                    <select id="estado" name="estado" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                        <option value="todos" @selected(request('estado', 'todos') === 'todos')>Todos</option>
                        <option value="activos" @selected(request('estado') === 'activos')>Activos</option>
                        <option value="inactivos" @selected(request('estado') === 'inactivos')>Inactivos</option>
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-[#00A8FF] px-4 py-2.5 text-sm font-bold text-[#0D0D0D] transition hover:bg-[#008bd1]">Buscar</button>
                <a href="{{ route('compras.proveedores.index') }}" class="rounded-lg border border-white/10 px-4 py-2.5 text-center text-sm font-semibold text-[#a7b4c1] transition hover:bg-white/5">Limpiar</a>
            </form>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/[0.03]">
                        <tr>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Proveedor</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">RFC</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Contacto</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Teléfono / correo</th>
                            <th class="px-5 py-3 text-left text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Estado</th>
                            <th class="px-5 py-3 text-right text-[11px] font-bold uppercase tracking-wide text-[#81909e]">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/[0.06]">
                        @forelse($proveedores as $proveedor)
                            <tr class="transition hover:bg-white/[0.025]">
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-white">{{ $proveedor->nombre }}</p>
                                    @if($proveedor->razon_social)<p class="mt-0.5 text-xs text-[#81909e]">{{ $proveedor->razon_social }}</p>@endif
                                    <p class="mt-1 text-[10px] font-semibold uppercase tracking-wide text-[#00A8FF]">{{ $proveedor->tipo_proveedor === 'EMPRESA' ? 'Empresa' : 'Persona' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-[#c7d0d9]">{{ $proveedor->rfc ?: '—' }}</td>
                                <td class="px-5 py-4 text-sm text-[#c7d0d9]">{{ $proveedor->contacto ?: '—' }}</td>
                                <td class="px-5 py-4 text-sm text-[#c7d0d9]">
                                    <p>{{ $proveedor->telefono ?: 'Sin teléfono' }}</p>
                                    <p class="mt-0.5 text-xs text-[#81909e]">{{ $proveedor->email ?: 'Sin correo' }}</p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4">
                                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $proveedor->activo ? 'bg-[#00A8FF]/10 text-[#80d6ff]' : 'bg-white/10 text-[#a7b4c1]' }}">{{ $proveedor->activo ? 'Activo' : 'Inactivo' }}</span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-right">
                                    <a href="{{ route('compras.proveedores.edit', $proveedor) }}" class="text-sm font-semibold text-[#00A8FF] hover:underline">Editar</a>
                                    @if($proveedor->activo)
                                        <form method="POST" action="{{ route('compras.proveedores.destroy', $proveedor) }}" class="ml-3 inline" onsubmit="return confirm('¿Desactivar este proveedor? Sus datos permanecerán en el sistema.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm font-semibold text-[#ff7373] hover:underline">Desactivar</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-6 py-14 text-center">
                                <p class="font-semibold text-white">No hay proveedores para mostrar</p>
                                <p class="mt-1 text-sm text-[#a7b4c1]">Cambia los filtros o registra el primer proveedor.</p>
                                <a href="{{ route('compras.proveedores.create') }}" class="mt-4 inline-flex rounded-lg bg-[#FF2B2B] px-4 py-2 text-sm font-bold text-white hover:bg-[#e51f25]">Registrar proveedor</a>
                            </td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-white/10 px-5 py-4">{{ $proveedores->links() }}</div>
        </section>
    </div>
</x-app-layout>
