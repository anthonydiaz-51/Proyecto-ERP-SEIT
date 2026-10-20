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
        <h2 class="font-semibold text-xl text-white">Ventas</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto py-6">

        <form method="GET" action="<?php echo e(route('comercial.ventas.index')); ?>"
              class="bg-white shadow rounded-lg p-4 mb-6 flex flex-wrap items-end gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Origen</label>
                <select name="origen" class="mt-1 block rounded-md border-gray-300 text-sm">
                    <option value="todas" <?php echo e($origen == 'todas' ? 'selected' : ''); ?>>Todas</option>
                    <option value="cotizaciones" <?php echo e($origen == 'cotizaciones' ? 'selected' : ''); ?>>Cotizaciones aceptadas</option>
                    <option value="ordenes" <?php echo e($origen == 'ordenes' ? 'selected' : ''); ?>>Órdenes entregadas</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Desde</label>
                <input type="date" name="desde" value="<?php echo e($desde); ?>"
                       class="mt-1 block rounded-md border-gray-300 text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Hasta</label>
                <input type="date" name="hasta" value="<?php echo e($hasta); ?>"
                       class="mt-1 block rounded-md border-gray-300 text-sm">
            </div>
            <div class="flex gap-3">
                <button type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                    Filtrar
                </button>
                <a href="<?php echo e(route('comercial.ventas.index')); ?>" class="px-4 py-2 text-sm text-gray-600">Limpiar</a>
            </div>
        </form>

        <p class="text-xs text-gray-500 mb-6">
            Una cotización aceptada deja de aparecer aquí cuando se genera su orden de servicio; a partir de ahí
            la venta se refleja en las órdenes entregadas. Los totales no se suman porque incluyen IVA de forma distinta.
        </p>

        <?php if($origen !== 'ordenes'): ?>
            <div class="bg-white shadow rounded-lg overflow-hidden mb-8">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-medium text-gray-800">Cotizaciones aceptadas sin orden</h3>
                    <span class="text-sm text-gray-700">Total: <strong>$<?php echo e(number_format($totalCotizaciones, 2)); ?></strong></span>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $cotizaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cotizacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($cotizacion->folio); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($cotizacion->cliente->nombre ?? '—'); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($cotizacion->fecha); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">$<?php echo e(number_format($cotizacion->total, 2)); ?></td>
                                <td class="px-6 py-4 text-right text-sm">
                                    <a href="<?php echo e(route('comercial.cotizaciones.edit', $cotizacion)); ?>" class="text-indigo-600 hover:underline">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay cotizaciones aceptadas en este periodo.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

                <?php if($origen !== 'cotizaciones'): ?>
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b flex justify-between items-center">
                    <h3 class="font-medium text-gray-800">Órdenes de servicio entregadas</h3>
                    <span class="text-sm text-gray-700">
                        Total: <strong>$<?php echo e(number_format($totalOrdenes, 2)); ?></strong>
                        · Cobrado: <strong>$<?php echo e(number_format($totalCobrado, 2)); ?></strong>
                    </span>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Entrega</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Costo total</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Pagado</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Saldo</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $ordenes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orden): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $pagado = $orden->pagos_sum_monto ?? 0;
                                $saldo = ($orden->costo_total ?? 0) - $pagado;
                            ?>
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($orden->folio); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($orden->cliente->nombre ?? '—'); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($orden->fecha_entrega ?? '—'); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">$<?php echo e(number_format($orden->costo_total, 2)); ?></td>
                                <td class="px-6 py-4 text-sm text-gray-500 text-right">$<?php echo e(number_format($pagado, 2)); ?></td>
                                <td class="px-6 py-4 text-sm text-right <?php echo e($saldo > 0 ? 'text-red-600' : 'text-green-600'); ?>">
                                    $<?php echo e(number_format($saldo, 2)); ?>

                                </td>
                                <td class="px-6 py-4 text-right text-sm space-x-3">
                                    <?php if($saldo > 0): ?>
                                        <a href="<?php echo e(route('finanzas.pagos.create', ['orden_id' => $orden->id])); ?>" class="text-indigo-600 hover:underline">Registrar pago</a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(route('sistemas.ordenes.edit', $orden)); ?>" class="text-gray-500 hover:underline">Ver</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                    No hay órdenes entregadas en este periodo.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/comercial/ventas/index.blade.php ENDPATH**/ ?>