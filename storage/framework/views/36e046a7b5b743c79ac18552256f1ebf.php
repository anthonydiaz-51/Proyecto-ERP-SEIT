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
        <h2 class="font-semibold text-xl text-gray-800">Nuevo cliente</h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-3xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="<?php echo e(route('comercial.clientes.store')); ?>">
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tipo de cliente</label>
                    <select name="tipo_cliente" class="mt-1 block w-full rounded-md border-gray-300">
                        <option value="PERSONA" <?php echo e(old('tipo_cliente') == 'PERSONA' ? 'selected' : ''); ?>>Persona</option>
                        <option value="EMPRESA" <?php echo e(old('tipo_cliente') == 'EMPRESA' ? 'selected' : ''); ?>>Empresa</option>
                    </select>
                    <?php $__errorArgs = ['tipo_cliente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="nombre" value="<?php echo e(old('nombre')); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300">
                    <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Razón social (si aplica)</label>
                    <input type="text" name="razon_social" value="<?php echo e(old('razon_social')); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">RFC</label>
                    <input type="text" name="rfc" value="<?php echo e(old('rfc')); ?>"
                           class="mt-1 block w-full rounded-md border-gray-300">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="telefono" value="<?php echo e(old('telefono')); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Notas</label>
                    <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('notas')); ?></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="reset"
                        class="px-4 py-2 text-sm text-gray-600"
                    >
                        Limpiar
                    </button>

                    <a
                        href="<?php echo e(route('comercial.clientes.index')); ?>"
                        class="px-4 py-2 text-sm text-gray-600"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700"
                    >
                        Guardar cliente
                    </button>
                </div>
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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/comercial/clientes/create.blade.php ENDPATH**/ ?>