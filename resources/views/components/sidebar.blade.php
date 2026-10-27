@php
    $rolId = auth()->user()?->rol_id;
@endphp

<aside
    x-data="{ open: { admin: true, comercial: true, finanzas: true, sistemas: true } }"
    x-show="sidebarOpen"
    x-cloak
    x-transition:enter="transform transition ease-in-out duration-200"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    id="app-sidebar"
    class="seit-sidebar fixed inset-y-0 left-0 z-40 flex h-screen min-h-screen w-72 shrink-0 flex-col lg:sticky lg:top-0"
>
    <div class="flex min-h-16 items-center justify-end border-b border-white/10 px-4 py-3 lg:hidden">
        <button
            type="button"
            @click="sidebarOpen = false"
            aria-label="Cerrar menú"
            title="Cerrar menú"
            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-400 transition hover:bg-white/5 hover:text-white focus:outline-none focus:ring-2 focus:ring-[#00A8FF] lg:hidden"
        >
            <span aria-hidden="true" class="text-xl leading-none">&times;</span>
        </button>
    </div>

    <nav class="flex-1 space-y-2 overflow-y-auto px-3 py-5">
        @if(in_array($rolId, [1, 2]))
            <section class="px-1 py-1">
                <button
                    type="button"
                    @click="open.admin = !open.admin"
                    class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400 transition hover:bg-[#00A8FF] hover:text-[#0D0D0D]"
                    :aria-expanded="open.admin"
                >
                    <span>Administración</span>
                    <span class="text-sm text-[#00A8FF]" x-text="open.admin ? '−' : '+'"></span>
                </button>
                <div x-show="open.admin" class="mt-1 space-y-1">
                    <a href="{{ route('administracion.usuarios.index') }}"
                       aria-current="{{ request()->routeIs('administracion.*') ? 'page' : 'false' }}"
                       class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('administracion.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                        <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                        Usuarios
                    </a>
                </div>
            </section>
        @endif

        <section class="px-1 py-1">
            <button
                type="button"
                @click="open.comercial = !open.comercial"
                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400 transition hover:bg-[#00A8FF] hover:text-[#0D0D0D]"
                :aria-expanded="open.comercial"
            >
                <span>Comercial</span>
                <span class="text-sm text-[#00A8FF]" x-text="open.comercial ? '−' : '+'"></span>
            </button>
            <div x-show="open.comercial" class="mt-1 space-y-1">
                <a href="{{ route('comercial.clientes.index') }}"
                   aria-current="{{ request()->routeIs('comercial.clientes.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('comercial.clientes.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Clientes
                </a>
                <a href="{{ route('comercial.cotizaciones.index') }}"
                   aria-current="{{ request()->routeIs('comercial.cotizaciones.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('comercial.cotizaciones.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Cotizaciones
                </a>
                <a href="{{ route('comercial.servicios.index') }}"
                   aria-current="{{ request()->routeIs('comercial.servicios.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('comercial.servicios.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Servicios
                </a>
                <a href="{{ route('comercial.ventas.index') }}"
                   aria-current="{{ request()->routeIs('comercial.ventas.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('comercial.ventas.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Ventas
                </a>
            </div>
        </section>

        <section class="px-1 py-1">
            <p class="px-3 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400">Inventario</p>
            <div class="mt-1 space-y-1">
                <a href="{{ route('inventario.index') }}"
                   aria-current="{{ request()->routeIs('inventario.index', 'inventario.productos.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('inventario.index', 'inventario.productos.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Productos y existencias
                </a>
                <a href="{{ route('inventario.movimientos.index') }}"
                   aria-current="{{ request()->routeIs('inventario.movimientos.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('inventario.movimientos.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Movimientos de stock
                </a>
            </div>
        </section>

        <section class="px-1 py-1">
            <button
                type="button"
                @click="open.finanzas = !open.finanzas"
                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400 transition hover:bg-[#00A8FF] hover:text-[#0D0D0D]"
                :aria-expanded="open.finanzas"
            >
                <span>Finanzas</span>
                <span class="text-sm text-[#00A8FF]" x-text="open.finanzas ? '−' : '+'"></span>
            </button>
            <div x-show="open.finanzas" class="mt-1 space-y-1">
                <a href="{{ route('finanzas.pagos.index') }}"
                   aria-current="{{ request()->routeIs('finanzas.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('finanzas.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    Pagos
                </a>
            </div>
        </section>

        <section class="px-1 py-1">
            <button
                type="button"
                @click="open.sistemas = !open.sistemas"
                class="flex w-full items-center justify-between rounded-lg px-3 py-2 text-[11px] font-bold uppercase tracking-[0.16em] text-gray-400 transition hover:bg-[#00A8FF] hover:text-[#0D0D0D]"
                :aria-expanded="open.sistemas"
            >
                <span>Sistemas</span>
                <span class="text-sm text-[#00A8FF]" x-text="open.sistemas ? '−' : '+'"></span>
            </button>
            <div x-show="open.sistemas" class="mt-1 space-y-1">
                <a href="{{ route('sistemas.ordenes.index') }}"
                   aria-current="{{ request()->routeIs('sistemas.*') ? 'page' : 'false' }}"
                   class="seit-nav-link flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm hover:bg-[#00A8FF] hover:text-[#0D0D0D] {{ request()->routeIs('sistemas.*') ? 'bg-[#00A8FF]/10 font-semibold text-[#00A8FF]' : 'text-gray-300' }}">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>
                    <span>Tickets / Órdenes</span>
                </a>
            </div>
        </section>

        <div class="my-3 border-t border-white/10"></div>

        @foreach ([
            'rh' => 'RH',
            'practicas' => 'Prácticas profesionales',
            'cursos' => 'Cursos',
        ] as $key => $label)
            <a href="{{ route('modulo.pendiente', $key) }}"
               class="flex items-center justify-between gap-2 rounded-lg px-3 py-2.5 text-xs font-semibold uppercase tracking-wide text-gray-500 transition hover:bg-[#00A8FF] hover:text-[#0D0D0D]">
                <span>{{ $label }}</span>
                <span class="rounded-full border border-white/10 px-2 py-0.5 text-[9px] font-medium normal-case tracking-normal text-gray-400">Próximamente</span>
            </a>
        @endforeach
    </nav>

    <div class="border-t border-white/10 p-4">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full rounded-lg px-3 py-2.5 text-left text-sm font-medium text-gray-400 transition hover:bg-[#FF2B2B] hover:text-[#0D0D0D]">
                Cerrar sesión
            </button>
        </form>
    </div>
</aside>
