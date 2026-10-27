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
        <div class="flex items-center justify-between gap-4">
            <div><p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Trazabilidad de almacén</p><h1 class="mt-1 text-2xl font-semibold text-white">Registrar movimiento</h1></div>
            <a href="<?php echo e(route('inventario.movimientos.index')); ?>" class="text-sm font-semibold text-[#a7b4c1] hover:text-white">← Historial de movimientos</a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="mx-auto max-w-3xl">
        <form method="POST" action="<?php echo e(route('inventario.movimientos.store')); ?>" class="space-y-6 rounded-2xl border border-[#00A8FF]/20 bg-[#111820] p-5 shadow-xl sm:p-8">
            <?php echo csrf_field(); ?>

            <div class="rounded-xl border border-[#00A8FF]/20 bg-[#00A8FF]/[0.06] p-4">
                <p class="text-sm font-semibold text-white">El movimiento actualiza la existencia y queda guardado en el historial.</p>
                <p class="mt-1 text-xs leading-5 text-[#a7b4c1]">Entrada suma unidades, salida las resta. Ajuste establece la existencia final indicada.</p>
            </div>

            <div>
                <label for="producto_id" class="mb-2 block text-sm font-medium text-white">Producto <span class="text-[#FF2B2B]">*</span></label>
                <select id="producto_id" name="producto_id" required class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <option value="">Selecciona un producto</option>
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($producto->id); ?>" data-existencia="<?php echo e((float) ($producto->inventario?->existencia ?? 0)); ?>" data-ubicacion="<?php echo e($producto->inventario?->ubicacion); ?>" <?php if((string) old('producto_id', $productoSeleccionado) === (string) $producto->id): echo 'selected'; endif; ?>>
                            <?php echo e($producto->nombre); ?> · <?php echo e($producto->codigo ?: 'Sin código'); ?> · Stock: <?php echo e(number_format((float) ($producto->inventario?->existencia ?? 0), 2)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['producto_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php if($productos->isEmpty()): ?><p class="mt-2 text-xs text-amber-300">No hay productos activos. Agrega primero un producto al inventario.</p><?php endif; ?>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="tipo" class="mb-2 block text-sm font-medium text-white">Tipo de movimiento <span class="text-[#FF2B2B]">*</span></label>
                    <select id="tipo" name="tipo" required class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                        <option value="ENTRADA" <?php if(old('tipo', 'ENTRADA') === 'ENTRADA'): echo 'selected'; endif; ?>>Entrada · agregar unidades</option>
                        <option value="SALIDA" <?php if(old('tipo') === 'SALIDA'): echo 'selected'; endif; ?>>Salida · retirar unidades</option>
                        <option value="AJUSTE" <?php if(old('tipo') === 'AJUSTE'): echo 'selected'; endif; ?>>Ajuste · definir existencia final</option>
                    </select>
                    <?php $__errorArgs = ['tipo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label id="cantidad-label" for="cantidad" class="mb-2 block text-sm font-medium text-white">Cantidad de unidades <span class="text-[#FF2B2B]">*</span></label>
                    <input id="cantidad" name="cantidad" type="number" min="0" step="0.01" max="99999999.99" required value="<?php echo e(old('cantidad')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <p id="cantidad-ayuda" class="mt-1 text-xs text-[#81909e]">La entrada se sumará a la existencia actual.</p>
                    <?php $__errorArgs = ['cantidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="referencia" class="mb-2 block text-sm font-medium text-white">Referencia</label>
                    <input id="referencia" name="referencia" type="text" maxlength="100" value="<?php echo e(old('referencia')); ?>" placeholder="Folio, factura, orden..." class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <?php $__errorArgs = ['referencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label for="ubicacion" class="mb-2 block text-sm font-medium text-white">Ubicación</label>
                    <input id="ubicacion" name="ubicacion" type="text" maxlength="100" value="<?php echo e(old('ubicacion')); ?>" placeholder="Se conserva si se deja vacío" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div>
                <label for="motivo" class="mb-2 block text-sm font-medium text-white">Motivo / observaciones</label>
                <textarea id="motivo" name="motivo" rows="3" maxlength="255" placeholder="Describe brevemente el movimiento" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]"><?php echo e(old('motivo')); ?></textarea>
                <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="flex justify-end gap-3 border-t border-white/10 pt-5">
                <a href="<?php echo e(route('inventario.index')); ?>" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Cancelar</a>
                <button type="submit" <?php if($productos->isEmpty()): echo 'disabled'; endif; ?> class="rounded-lg bg-[#FF2B2B] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#e51f25] disabled:cursor-not-allowed disabled:opacity-50">Aplicar movimiento</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tipo = document.getElementById('tipo');
            const cantidad = document.getElementById('cantidad');
            const ayuda = document.getElementById('cantidad-ayuda');
            const etiqueta = document.getElementById('cantidad-label');
            const ubicacion = document.getElementById('ubicacion');
            const producto = document.getElementById('producto_id');

            const actualizar = () => {
                if (tipo.value === 'AJUSTE') {
                    etiqueta.firstChild.textContent = 'Existencia final ';
                    cantidad.min = '0';
                    ayuda.textContent = 'Escribe el total que debe quedar después del ajuste.';
                } else {
                    etiqueta.firstChild.textContent = 'Cantidad de unidades ';
                    cantidad.min = '0.01';
                    ayuda.textContent = tipo.value === 'SALIDA'
                        ? 'La cantidad se descontará de la existencia actual.'
                        : 'La cantidad se sumará a la existencia actual.';
                }
            };

            producto.addEventListener('change', () => {
                const option = producto.selectedOptions[0];
                if (option?.dataset.ubicacion && !ubicacion.value) ubicacion.value = option.dataset.ubicacion;
            });
            tipo.addEventListener('change', actualizar);
            actualizar();
        });
    </script>
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
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/inventario/movimientos/create.blade.php ENDPATH**/ ?>