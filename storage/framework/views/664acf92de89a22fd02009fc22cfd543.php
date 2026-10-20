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
            <h2 class="font-semibold text-xl text-white">Pagos</h2>
            <a href="<?php echo e(route('finanzas.pagos.create')); ?>"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Registrar pago
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Referencia</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Registró</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $pagos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pago): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($pago->fecha); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900"><?php echo e($pago->orden->folio ?? '—'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($pago->orden->cliente->nombre ?? '—'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($pago->metodo_pago); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($pago->referencia ?? '—'); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-900 text-right">$<?php echo e(number_format($pago->monto, 2)); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?php echo e($pago->usuario->nombre ?? '—'); ?></td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="<?php echo e(route('finanzas.pagos.edit', $pago)); ?>" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay pagos registrados.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <?php echo e($pagos->links()); ?>

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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/finanzas/pagos/index.blade.php ENDPATH**/ ?>