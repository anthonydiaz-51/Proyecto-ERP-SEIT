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
        <h2 class="font-semibold text-xl text-gray-800">Editar servicio</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="<?php echo e(route('comercial.servicios.update', $servicio)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select name="categoria_id" class="mt-1 block w-full rounded-md border-gray-300">
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($categoria->id); ?>" <?php echo e(old('categoria_id', $servicio->categoria_id) == $categoria->id ? 'selected' : ''); ?>>
                                <?php echo e($categoria->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['categoria_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Servicio</label>
                    <input type="text" name="servicio" value="<?php echo e(old('servicio', $servicio->servicio)); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300">
                    <?php $__errorArgs = ['servicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('descripcion', $servicio->descripcion)); ?></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Precio base</label>
                        <input type="number" step="0.01" name="precio_base" value="<?php echo e(old('precio_base', $servicio->precio_base)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        <?php $__errorArgs = ['precio_base'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tipo de precio</label>
                        <input type="text" name="tipo_precio" value="<?php echo e(old('tipo_precio', $servicio->tipo_precio)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="promocion" value="1" <?php echo e(old('promocion', $servicio->promocion) ? 'checked' : ''); ?>>
                        <span class="ml-2 text-sm text-gray-700">Marcar como promoción</span>
                    </label>
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input type="hidden" name="activo" value="0">
                        <input type="checkbox" name="activo" value="1" <?php echo e(old('activo', $servicio->activo) ? 'checked' : ''); ?>>
                        <span class="ml-2 text-sm text-gray-700">Servicio activo</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="<?php echo e(route('comercial.servicios.index')); ?>" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            <form method="POST" action="<?php echo e(route('comercial.servicios.destroy', $servicio)); ?>"
                  onsubmit="return confirm('¿Desactivar este servicio?');" class="mt-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-red-600 text-sm hover:underline">Desactivar servicio</button>
            </form>
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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/comercial/servicios/edit.blade.php ENDPATH**/ ?>