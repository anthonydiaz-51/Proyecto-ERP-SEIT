<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php
        $rolId = auth()->user()->rol_id;
    ?>

    <div class="mx-auto max-w-7xl space-y-8">
        <section class="relative isolate overflow-hidden rounded-2xl border border-[#00A8FF]/25 bg-[#0D0D0D] text-white shadow-[0_24px_70px_rgba(0,0,0,0.4)]">
            <div class="pointer-events-none absolute -right-24 -top-28 -z-10 h-80 w-80 rounded-full bg-[#00A8FF]/15 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-32 left-1/3 -z-10 h-72 w-72 rounded-full bg-[#FF2B2B]/10 blur-3xl"></div>
            <div class="grid lg:grid-cols-[minmax(0,1.45fr)_minmax(280px,0.75fr)]">
                <div class="relative p-7 sm:p-10 lg:p-12">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-[#00A8FF]/30 bg-[#00A8FF]/[0.08] px-3 py-1.5">
                        <span class="h-2 w-2 rounded-full bg-[#00A8FF] shadow-[0_0_12px_#00A8FF]" aria-hidden="true"></span>
                        <p class="text-[11px] font-semibold uppercase tracking-[0.2em] text-[#8bd8ff]">SEIT GDL <span class="mx-1 text-white/30">/</span> Panel principal</p>
                    </div>

                    <h1 class="max-w-2xl text-3xl font-semibold leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                        Bienvenido, <span class="text-white"><?php echo e(auth()->user()->nombre); ?></span>
                    </h1>
                    <p class="mt-5 max-w-xl text-sm leading-7 text-[#a7b4c1] sm:text-base">
                        Administra desde un solo lugar la operación comercial, las órdenes de servicio y los pagos de SEIT.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="<?php echo e(route('comercial.cotizaciones.create')); ?>" class="inline-flex items-center gap-2 rounded-lg bg-[#FF2B2B] px-5 py-3 text-sm font-bold text-white shadow-[0_8px_24px_rgba(255,43,43,0.2)] transition hover:-translate-y-0.5 hover:bg-[#e51f25] focus:outline-none focus:ring-2 focus:ring-[#FF2B2B] focus:ring-offset-2 focus:ring-offset-[#0D0D0D]">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 5v14m-7-7h14" /></svg>
                            Nueva cotización
                        </a>
                        <a href="<?php echo e(route('sistemas.ordenes.index')); ?>" class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-white/[0.03] px-5 py-3 text-sm font-semibold text-white transition hover:border-[#00A8FF]/60 hover:bg-[#00A8FF]/[0.08] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                            Ver órdenes de servicio
                            <span aria-hidden="true" class="text-[#00A8FF]">→</span>
                        </a>
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 border-t border-white/10 pt-5 text-xs text-[#a7b4c1]">
                        <span class="inline-flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-[#00A8FF]" aria-hidden="true"></span>Gestión comercial</span>
                        <span class="inline-flex items-center gap-2"><span class="h-1.5 w-1.5 rounded-full bg-[#FF2B2B]" aria-hidden="true"></span>Soporte técnico</span>
                    </div>
                </div>

                <aside class="border-t border-white/10 bg-white/[0.025] p-7 sm:p-9 lg:border-l lg:border-t-0">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-[#00A8FF]">Accesos directos</p>
                            <p class="mt-1 text-sm text-[#a7b4c1]">Atajos de uso frecuente</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-[#00A8FF]/25 bg-[#00A8FF]/10 text-[#00A8FF]" aria-hidden="true">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"><path stroke-linecap="round" stroke-linejoin="round" d="M13 3 4 14h7l-1 7 10-12h-7l1-6Z" /></svg>
                        </div>
                    </div>

                    <nav class="mt-5 space-y-2" aria-label="Accesos directos">
                        <a href="<?php echo e(route('comercial.clientes.index')); ?>" class="group flex items-center justify-between gap-4 rounded-xl border border-transparent px-3 py-3 text-sm text-[#e5edf4] transition hover:border-[#00A8FF]/20 hover:bg-[#00A8FF]/[0.06]">
                            <span class="flex items-center gap-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.06] text-[#00A8FF]">01</span>Directorio de clientes</span><span aria-hidden="true" class="text-[#00A8FF] transition group-hover:translate-x-1">→</span>
                        </a>
                        <a href="<?php echo e(route('comercial.ventas.index')); ?>" class="group flex items-center justify-between gap-4 rounded-xl border border-transparent px-3 py-3 text-sm text-[#e5edf4] transition hover:border-[#00A8FF]/20 hover:bg-[#00A8FF]/[0.06]">
                            <span class="flex items-center gap-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.06] text-[#00A8FF]">02</span>Ventas</span><span aria-hidden="true" class="text-[#00A8FF] transition group-hover:translate-x-1">→</span>
                        </a>
                        <a href="<?php echo e(route('finanzas.pagos.index')); ?>" class="group flex items-center justify-between gap-4 rounded-xl border border-transparent px-3 py-3 text-sm text-[#e5edf4] transition hover:border-[#00A8FF]/20 hover:bg-[#00A8FF]/[0.06]">
                            <span class="flex items-center gap-3"><span class="flex h-8 w-8 items-center justify-center rounded-lg bg-white/[0.06] text-[#00A8FF]">03</span>Pagos</span><span aria-hidden="true" class="text-[#00A8FF] transition group-hover:translate-x-1">→</span>
                        </a>
                    </nav>

                    <p class="mt-5 border-t border-white/10 pt-4 text-xs text-[#81909e]">
                        <span class="text-white"><?php echo e(now()->format('d/m/Y')); ?></span><span class="mx-2 text-[#FF2B2B]">•</span>Espacio de trabajo SEIT
                    </p>
                </aside>
            </div>
        </section>

        <section aria-labelledby="modules-heading">
            <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#FF2B2B]">Operación SEIT</p>
                    <h2 id="modules-heading" class="mt-1 text-2xl font-semibold tracking-tight text-white">Módulos de trabajo</h2>
                </div>
                <span class="text-sm text-[#a7b4c1]">Accede a las herramientas de tu área</span>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <a href="<?php echo e(route('comercial.clientes.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#00A8FF] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#00A8FF]/10 text-[#00A8FF]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m16 0v-2a4 4 0 0 0-3-3.87M14 3.13a4 4 0 0 1 0 7.75M14 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#00A8FF]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#00A8FF]">Clientes</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Consulta y administra el directorio de clientes.</p>
                </a>
                <a href="<?php echo e(route('comercial.cotizaciones.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#FF2B2B] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FF2B2B]/10 text-[#FF2B2B]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3h7l5 5v13H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Zm7 0v5h5M9 13h6m-6 4h6" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#FF2B2B]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#FF2B2B]">Cotizaciones</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Prepara propuestas y da seguimiento a su estado.</p>
                </a>
                <a href="<?php echo e(route('comercial.servicios.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#00A8FF] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#00A8FF]/10 text-[#00A8FF]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m14.7 6.3 3 3M4 20l4.5-1 10.8-10.8a2.1 2.1 0 0 0-3-3L5.5 16 4 20Zm9-14 4 4" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#00A8FF]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#00A8FF]">Servicios</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Revisa el catálogo de servicios disponibles.</p>
                </a>
                <a href="<?php echo e(route('inventario.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#FF2B2B] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FF2B2B]/10 text-[#FF2B2B]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4-8 4-8-4Zm0 0v10l8 4 8-4V7m-8 4v10" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#FF2B2B]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#FF2B2B]">Inventario</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Consulta productos, existencias y movimientos de almacén.</p>
                </a>
                <a href="<?php echo e(route('compras.proveedores.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#00A8FF] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#00A8FF]/10 text-[#00A8FF]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7h11v11H3zM14 11h4l3 3v4h-7zM7 18a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm10 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Z" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#00A8FF]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#00A8FF]">Proveedores</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Administra el directorio y los datos de contacto de proveedores.</p>
                </a>
                <a href="<?php echo e(route('comercial.ventas.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#00A8FF] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#00A8FF]/10 text-[#00A8FF]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3v18h18M7 14l4-4 3 3 6-7" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#00A8FF]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#00A8FF]">Ventas</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Consulta ventas y cotizaciones convertidas.</p>
                </a>
                <a href="<?php echo e(route('sistemas.ordenes.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#FF2B2B] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FF2B2B]/10 text-[#FF2B2B]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#FF2B2B]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#FF2B2B]">Órdenes de servicio</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Da seguimiento a órdenes y tickets de servicio.</p>
                </a>
                <a href="<?php echo e(route('finanzas.pagos.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                    <div class="absolute inset-y-0 left-0 w-1 bg-[#00A8FF] opacity-60 transition group-hover:opacity-100"></div>
                    <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#00A8FF]/10 text-[#00A8FF]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" /><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18m-13 5h3" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#00A8FF]" aria-hidden="true">↗</span></div>
                    <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#00A8FF]">Pagos</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Registra y consulta pagos asociados a órdenes.</p>
                </a>
                <?php if(in_array($rolId, [1, 2])): ?>
                    <a href="<?php echo e(route('administracion.usuarios.index')); ?>" class="group relative overflow-hidden rounded-xl border border-[#00A8FF]/15 bg-[#111820] p-5 transition duration-200 hover:-translate-y-1 hover:border-[#00A8FF]/55 hover:shadow-[0_14px_35px_rgba(0,168,255,0.08)] focus:outline-none focus:ring-2 focus:ring-[#00A8FF]">
                        <div class="absolute inset-y-0 left-0 w-1 bg-[#FF2B2B] opacity-60 transition group-hover:opacity-100"></div>
                        <div class="flex items-start justify-between gap-4"><div class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#FF2B2B]/10 text-[#FF2B2B]"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m16 0v-2a4 4 0 0 0-3-3.87M14 3.13a4 4 0 0 1 0 7.75M14 7a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" /></svg></div><span class="text-lg text-white/25 transition group-hover:translate-x-1 group-hover:text-[#FF2B2B]" aria-hidden="true">↗</span></div>
                        <h3 class="mt-5 font-semibold text-white transition group-hover:text-[#FF2B2B]">Usuarios</h3><p class="mt-1 text-sm leading-6 text-[#a7b4c1]">Administra el acceso de los usuarios al sistema.</p>
                    </a>
                <?php endif; ?>
            </div>
        </section>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/dashboard.blade.php ENDPATH**/ ?>