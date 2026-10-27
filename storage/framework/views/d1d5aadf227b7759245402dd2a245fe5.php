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
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div><p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Trazabilidad de almacén</p><h1 class="mt-1 text-2xl font-semibold text-white">Movimientos de inventario</h1></div>
            <div class="flex gap-2"><a href="<?php echo e(route('inventario.index')); ?>" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">← Inventario</a><a href="<?php echo e(route('inventario.movimientos.create')); ?>" class="rounded-lg bg-[#FF2B2B] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#e51f25]">+ Registrar movimiento</a></div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="mx-auto max-w-7xl space-y-5">
        <?php if(session('success')): ?><div class="rounded-lg border border-[#00A8FF]/30 bg-[#00A8FF]/10 px-4 py-3 text-sm text-white" role="status"><?php echo e(session('success')); ?></div><?php endif; ?>

        <form method="GET" action="<?php echo e(route('inventario.movimientos.index')); ?>" class="grid gap-3 rounded-2xl border border-[#00A8FF]/15 bg-[#111820] p-4 sm:grid-cols-[minmax(0,1fr)_220px_auto]">
            <input name="q" type="search" value="<?php echo e(request('q')); ?>" placeholder="Buscar por producto, código, referencia o motivo" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none">
            <select name="tipo" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                <option value="">Todos los tipos</option>
                <option value="ENTRADA" <?php if(request('tipo') === 'ENTRADA'): echo 'selected'; endif; ?>>Entradas</option>
                <option value="SALIDA" <?php if(request('tipo') === 'SALIDA'): echo 'selected'; endif; ?>>Salidas</option>
                <option value="AJUSTE" <?php if(request('tipo') === 'AJUSTE'): echo 'selected'; endif; ?>>Ajustes</option>
            </select>
            <div class="flex gap-2"><button class="rounded-lg bg-[#00A8FF] px-4 py-2.5 text-sm font-bold text-[#0D0D0D] hover:bg-[#008bd1]">Filtrar</button><a href="<?php echo e(route('inventario.movimientos.index')); ?>" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Limpiar</a></div>
        </form>

        <div class="overflow-hidden rounded-2xl border border-[#00A8FF]/15 bg-[#111820]">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10 text-left text-sm">
                    <thead class="bg-white/[0.03] text-[11px] uppercase tracking-wider text-[#a7b4c1]"><tr><th class="px-5 py-4">Fecha</th><th class="px-5 py-4">Producto</th><th class="px-5 py-4">Movimiento</th><th class="px-5 py-4">Cantidad</th><th class="px-5 py-4">Referencia / motivo</th><th class="px-5 py-4">Registró</th></tr></thead>
                    <tbody class="divide-y divide-white/5">
                        <?php $__empty_1 = true; $__currentLoopData = $movimientos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition hover:bg-white/[0.025]">
                                <td class="whitespace-nowrap px-5 py-4 text-[#a7b4c1]"><?php echo e($movimiento->created_at?->format('d/m/Y H:i') ?? '—'); ?></td>
                                <td class="min-w-52 px-5 py-4"><p class="font-semibold text-white"><?php echo e($movimiento->producto?->nombre ?? 'Producto eliminado'); ?></p><p class="mt-0.5 text-xs text-[#81909e]"><?php echo e($movimiento->producto?->codigo ?: 'Sin código'); ?></p></td>
                                <td class="px-5 py-4">
                                    <?php ($coloresTipo = ['ENTRADA' => 'bg-[#00A8FF]/10 text-[#80d6ff]', 'SALIDA' => 'bg-[#FF2B2B]/10 text-[#ff7373]', 'AJUSTE' => 'bg-amber-400/10 text-amber-300']); ?>
                                    <span class="rounded-full px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide <?php echo e($coloresTipo[$movimiento->tipo] ?? 'bg-white/10 text-white'); ?>"><?php echo e($movimiento->tipo); ?></span>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 font-bold text-white"><?php echo e(number_format((float) $movimiento->cantidad, 2)); ?> <span class="text-xs font-normal text-[#81909e]"><?php echo e($movimiento->tipo === 'AJUSTE' ? 'existencia final' : 'unidades'); ?></span></td>
                                <td class="max-w-xs px-5 py-4"><p class="truncate font-medium text-white"><?php echo e($movimiento->referencia ?: '—'); ?></p><p class="mt-0.5 line-clamp-2 text-xs text-[#81909e]"><?php echo e($movimiento->motivo ?: 'Sin motivo especificado'); ?></p></td>
                                <td class="whitespace-nowrap px-5 py-4 text-[#a7b4c1]"><?php echo e(trim(($movimiento->usuario?->nombre ?? '') . ' ' . ($movimiento->usuario?->apellido ?? '')) ?: '—'); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="px-5 py-14 text-center"><p class="font-semibold text-white">Aún no hay movimientos registrados</p><p class="mt-1 text-sm text-[#a7b4c1]">Al agregar una entrada, salida o ajuste aparecerá aquí.</p><a href="<?php echo e(route('inventario.movimientos.create')); ?>" class="mt-4 inline-flex text-sm font-semibold text-[#00A8FF] hover:underline">Registrar el primer movimiento →</a></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($movimientos->hasPages()): ?><div class="border-t border-white/10 p-4"><?php echo e($movimientos->links()); ?></div><?php endif; ?>
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
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/inventario/movimientos/index.blade.php ENDPATH**/ ?>