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
            <div>
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Abastecimiento SEIT</p>
                <h1 class="mt-1 text-2xl font-semibold text-white">Compras y recepciones</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('compras.proveedores.index')); ?>" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:border-[#00A8FF]/40 hover:bg-[#00A8FF]/10">Proveedores</a>
                <a href="<?php echo e(route('compras.create')); ?>" class="rounded-lg bg-[#FF2B2B] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#e51f25]">+ Registrar compra</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="mx-auto max-w-7xl space-y-6">
        <?php if(session('success')): ?>
            <div class="rounded-lg border border-[#00A8FF]/30 bg-[#00A8FF]/10 px-4 py-3 text-sm text-white" role="status"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <section class="grid gap-3 sm:grid-cols-2">
            <div class="rounded-xl border border-white/10 bg-[#111820] p-4"><p class="text-xs text-[#a7b4c1]">Compras recibidas</p><p class="mt-1 text-2xl font-bold text-white"><?php echo e(number_format($totalCompras)); ?></p></div>
            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-4"><p class="text-xs text-[#a7b4c1]">Importe registrado este mes</p><p class="mt-1 text-2xl font-bold text-[#00A8FF]">$<?php echo e(number_format((float) $importeMes, 2)); ?></p></div>
        </section>

        <section class="overflow-hidden rounded-2xl border border-white/10 bg-[#111820]">
            <form method="GET" action="<?php echo e(route('compras.index')); ?>" class="grid gap-3 border-b border-white/10 p-4 sm:grid-cols-[minmax(0,1fr)_190px_190px_auto_auto] sm:items-end">
                <div>
                    <label for="q" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Buscar</label>
                    <input id="q" type="search" name="q" value="<?php echo e(request('q')); ?>" placeholder="Proveedor, RFC o referencia" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                </div>
                <div>
                    <label for="desde" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Desde</label>
                    <input id="desde" type="date" name="desde" value="<?php echo e(request('desde')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                </div>
                <div>
                    <label for="hasta" class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Hasta</label>
                    <input id="hasta" type="date" name="hasta" value="<?php echo e(request('hasta')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                </div>
                <button type="submit" class="rounded-lg bg-[#00A8FF] px-4 py-2.5 text-sm font-bold text-[#0D0D0D] transition hover:bg-[#008bd1]">Filtrar</button>
                <a href="<?php echo e(route('compras.index')); ?>" class="rounded-lg border border-white/10 px-4 py-2.5 text-center text-sm font-semibold text-[#a7b4c1] transition hover:bg-white/5">Limpiar</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $compras; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compra): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="transition hover:bg-white/[0.025]">
                                <td class="whitespace-nowrap px-5 py-4">
                                    <a href="<?php echo e(route('compras.show', $compra)); ?>" class="text-sm font-bold text-[#00A8FF] hover:underline">COMPRA #<?php echo e(str_pad((string) $compra->id, 6, '0', STR_PAD_LEFT)); ?></a>
                                    <p class="mt-1 text-xs text-[#81909e]"><?php echo e($compra->referencia_proveedor ?: 'Sin referencia externa'); ?></p>
                                </td>
                                <td class="px-5 py-4 text-sm text-white">
                                    <p class="font-semibold"><?php echo e($compra->proveedor?->nombre ?? 'Proveedor eliminado'); ?></p>
                                    <p class="mt-0.5 text-xs text-[#81909e]"><?php echo e($compra->proveedor?->rfc ?: 'Sin RFC'); ?></p>
                                </td>
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-[#c7d0d9]"><?php echo e($compra->fecha?->format('d/m/Y')); ?></td>
                                <td class="px-5 py-4 text-sm text-[#c7d0d9]"><?php echo e(number_format($compra->detalles_count)); ?> líneas</td>
                                <td class="whitespace-nowrap px-5 py-4 text-right text-sm font-bold text-white">$<?php echo e(number_format((float) $compra->total, 2)); ?></td>
                                <td class="whitespace-nowrap px-5 py-4 text-right"><a href="<?php echo e(route('compras.show', $compra)); ?>" class="text-sm font-semibold text-[#00A8FF] hover:underline">Ver detalle</a></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr><td colspan="6" class="px-6 py-14 text-center">
                                <p class="font-semibold text-white">Todavía no hay compras registradas</p>
                                <p class="mt-1 text-sm text-[#a7b4c1]">Registra una compra para recibir sus productos y actualizar existencias.</p>
                                <a href="<?php echo e(route('compras.create')); ?>" class="mt-4 inline-flex rounded-lg bg-[#FF2B2B] px-4 py-2 text-sm font-bold text-white hover:bg-[#e51f25]">Registrar compra</a>
                            </td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="border-t border-white/10 px-5 py-4"><?php echo e($compras->links()); ?></div>
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
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/compras/index.blade.php ENDPATH**/ ?>