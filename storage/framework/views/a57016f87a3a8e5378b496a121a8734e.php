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
            <h2 class="font-semibold text-xl text-white">Tickets / Órdenes de Servicio</h2>
            <a href="<?php echo e(route('sistemas.ordenes.create')); ?>"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nueva orden
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
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Técnico</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Prioridad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Costo</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($orden->folio); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($orden->cliente->nombre ?? '—'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($orden->tecnico->nombre ?? 'Sin asignar'); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <?php
                                    $coloresPrioridad = [
                                        'URGENTE' => 'text-red-600 font-semibold',
                                        'ALTA' => 'text-orange-600',
                                        'MEDIA' => 'text-amber-600',
                                        'BAJA' => 'text-gray-500',
                                    ];
                                ?>
                                <span class="<?php echo e($coloresPrioridad[$orden->prioridad] ?? 'text-gray-500'); ?>">
                                    <?php echo e($orden->prioridad ?? '—'); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <?php
                                    $coloresEstado = [
                                        'RECIBIDO' => 'text-blue-600',
                                        'DIAGNOSTICO' => 'text-indigo-600',
                                        'COTIZACION' => 'text-purple-600',
                                        'AUTORIZADO' => 'text-teal-600',
                                        'EN_PROCESO' => 'text-amber-600',
                                        'LISTO' => 'text-green-600',
                                        'ENTREGADO' => 'text-gray-500',
                                        'CANCELADO' => 'text-red-500',
                                    ];
                                ?>
                                <span class="<?php echo e($coloresEstado[$orden->estado] ?? 'text-gray-500'); ?>">
                                    <?php echo e($orden->estado); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">$<?php echo e(number_format($orden->costo_total, 2)); ?></td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="<?php echo e(route('sistemas.ordenes.edit', $orden)); ?>" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay órdenes de servicio registradas.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($ordenes->links()); ?>

        </div>
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

<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/sistemas/ordenes-servicio/index.blade.php ENDPATH**/ ?>