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
        <section class="overflow-hidden rounded-lg bg-[#17191c] text-white shadow-sm">
            <div class="grid lg:grid-cols-[minmax(0,1.4fr)_minmax(260px,0.8fr)]">
                <div class="p-7 sm:p-10 lg:p-12">
                    <p class="mb-4 text-xs font-semibold uppercase tracking-[0.18em] text-red-400">SEIT · Plataforma de gestión</p>
                    <h1 class="max-w-2xl text-3xl font-semibold leading-tight sm:text-4xl">Bienvenido, <?php echo e(auth()->user()->nombre); ?></h1>
                    <p class="mt-4 max-w-xl text-sm leading-6 text-gray-300 sm:text-base">
                        Administra desde un solo lugar la operación comercial, las órdenes de servicio y los pagos de SEIT.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="<?php echo e(route('comercial.cotizaciones.create')); ?>" class="inline-flex items-center rounded-md bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-[#17191c]">
                            Nueva cotización
                        </a>
                        <a href="<?php echo e(route('sistemas.ordenes.index')); ?>" class="inline-flex items-center rounded-md border border-white/25 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white">
                            Ver órdenes de servicio
                        </a>
                    </div>
                </div>

                <div class="border-t border-white/10 bg-white/[0.04] p-7 sm:p-10 lg:border-l lg:border-t-0">
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-gray-400">Accesos directos</p>
                    <div class="mt-5 divide-y divide-white/10">
                        <a href="<?php echo e(route('comercial.clientes.index')); ?>" class="flex items-center justify-between gap-4 py-4 text-sm text-gray-100 transition hover:text-white">
                            <span>Directorio de clientes</span><span aria-hidden="true" class="text-red-400">→</span>
                        </a>
                        <a href="<?php echo e(route('comercial.ventas.index')); ?>" class="flex items-center justify-between gap-4 py-4 text-sm text-gray-100 transition hover:text-white">
                            <span>Ventas</span><span aria-hidden="true" class="text-red-400">→</span>
                        </a>
                        <a href="<?php echo e(route('finanzas.pagos.index')); ?>" class="flex items-center justify-between gap-4 py-4 text-sm text-gray-100 transition hover:text-white">
                            <span>Pagos</span><span aria-hidden="true" class="text-red-400">→</span>
                        </a>
                    </div>
                    <p class="mt-5 border-t border-white/10 pt-5 text-xs text-gray-400"><?php echo e(now()->format('d/m/Y')); ?> · Espacio de trabajo SEIT</p>
                </div>
            </div>
        </section>

        <section aria-labelledby="modules-heading">
            <div class="mb-4 flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.16em] text-red-700 dark:text-red-400">Operación</p>
                    <h2 id="modules-heading" class="mt-1 text-xl font-semibold text-gray-900 dark:text-white">Módulos de trabajo</h2>
                </div>
                <span class="hidden text-sm text-gray-500 dark:text-gray-400 sm:block">Accede a las herramientas de tu área</span>
            </div>

            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                <a href="<?php echo e(route('comercial.clientes.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                    <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Clientes</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Consulta y administra el directorio de clientes.</p>
                </a>
                <a href="<?php echo e(route('comercial.cotizaciones.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                    <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Cotizaciones</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Prepara propuestas y da seguimiento a su estado.</p>
                </a>
                <a href="<?php echo e(route('comercial.servicios.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                    <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Servicios</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Revisa el catálogo de servicios disponibles.</p>
                </a>
                <a href="<?php echo e(route('comercial.ventas.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                    <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Ventas</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Consulta ventas y cotizaciones convertidas.</p>
                </a>
                <a href="<?php echo e(route('sistemas.ordenes.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                    <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Órdenes de servicio</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Da seguimiento a órdenes y tickets de servicio.</p>
                </a>
                <a href="<?php echo e(route('finanzas.pagos.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                    <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Pagos</h3>
                    <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Registra y consulta pagos asociados a órdenes.</p>
                </a>
                <?php if(in_array($rolId, [1, 2])): ?>
                    <a href="<?php echo e(route('administracion.usuarios.index')); ?>" class="group rounded-lg border border-gray-200 bg-white p-5 transition hover:border-red-300 hover:shadow-sm focus:outline-none focus:ring-2 focus:ring-red-600 dark:border-gray-700 dark:bg-gray-800 dark:hover:border-red-500">
                        <h3 class="mt-3 font-semibold text-gray-900 group-hover:text-red-700 dark:text-white dark:group-hover:text-red-400">Usuarios</h3>
                        <p class="mt-1 text-sm leading-5 text-gray-500 dark:text-gray-400">Administra el acceso de los usuarios al sistema.</p>
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