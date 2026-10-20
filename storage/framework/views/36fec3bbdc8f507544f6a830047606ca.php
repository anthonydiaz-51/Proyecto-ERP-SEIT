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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Cotizaciones</h2>
            <a href="<?php echo e(route('comercial.cotizaciones.create')); ?>"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nueva cotización
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="max-w-7xl mx-auto mt-4">
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-md text-sm">
                <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    <div class="max-w-7xl mx-auto py-6">
        <form method="GET" action="<?php echo e(route('comercial.cotizaciones.index')); ?>" class="mb-4 flex flex-wrap items-end gap-3">
            <div class="w-full max-w-sm">
                <label for="folio" class="mb-1 block text-sm font-medium text-gray-700">Buscar por folio</label>
                <input
                    id="folio"
                    type="search"
                    name="folio"
                    value="<?php echo e($folio); ?>"
                    maxlength="50"
                    placeholder="Ej. COT-2026-001"
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                >
            </div>
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                Buscar
            </button>
            <?php if($folio !== ''): ?>
                <a href="<?php echo e(route('comercial.cotizaciones.index')); ?>" class="px-2 py-2 text-sm text-gray-600 hover:text-gray-900">Limpiar</a>
            <?php endif; ?>
        </form>

        <?php
            $grupos = [
                [
                    'titulo' => 'Cotizaciones pendientes y aceptadas',
                    'cotizaciones' => $cotizacionesActivas,
                    'vacio' => 'No hay cotizaciones pendientes o aceptadas que coincidan con la búsqueda.',
                ],
                [
                    'titulo' => 'Cotizaciones rechazadas, vencidas o canceladas',
                    'cotizaciones' => $cotizacionesCerradas,
                    'vacio' => 'No hay cotizaciones rechazadas, vencidas o canceladas que coincidan con la búsqueda.',
                ],
            ];
            $colores = [
                'PENDIENTE' => 'text-amber-600',
                'ACEPTADA' => 'text-green-600',
                'RECHAZADA' => 'text-red-500',
                'VENCIDA' => 'text-gray-400',
                'CANCELADA' => 'text-gray-400',
            ];
        ?>

        <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <section class="mb-8" aria-label="<?php echo e($grupo['titulo']); ?>">
                <h3 class="mb-3 text-lg font-semibold text-gray-800"><?php echo e($grupo['titulo']); ?></h3>
                <div class="overflow-hidden rounded-lg bg-white shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Folio</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium uppercase text-gray-500">Estado</th>
                                <th class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php $__empty_1 = true; $__currentLoopData = $grupo['cotizaciones']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cotizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($cotizacion->folio); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($cotizacion->cliente->nombre ?? '—'); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($cotizacion->fecha); ?></td>
                                    <td class="px-6 py-4 text-sm text-gray-500">$<?php echo e(number_format($cotizacion->total, 2)); ?></td>
                                    <td class="px-6 py-4 text-sm">
                                        <span class="<?php echo e($colores[$cotizacion->estado] ?? 'text-gray-500'); ?>"><?php echo e($cotizacion->estado); ?></span>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm">
                                        <a href="<?php echo e(route('comercial.cotizaciones.edit', $cotizacion)); ?>" class="text-indigo-600 hover:underline">Editar</a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500"><?php echo e($grupo['vacio']); ?></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <?php echo e($grupo['cotizaciones']->links()); ?>

                </div>
            </section>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/comercial/cotizaciones/index.blade.php ENDPATH**/ ?>