<?php
    $editando = $proveedor !== null;
    $valor = fn (string $campo) => old($campo, $proveedor?->{$campo});
?>

<?php if($errors->any()): ?>
    <div class="mb-5 rounded-xl border border-[#FF2B2B]/30 bg-[#FF2B2B]/10 p-4 text-sm text-[#ffb2b2]">
        <p class="font-semibold">Revisa los datos del formulario:</p>
        <ul class="mt-2 list-inside list-disc space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e($editando ? route('compras.proveedores.update', $proveedor) : route('compras.proveedores.store')); ?>" class="space-y-6 rounded-2xl border border-[#00A8FF]/20 bg-[#111820] p-5 shadow-xl sm:p-8">
    <?php echo csrf_field(); ?>
    <?php if($editando): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

    <section>
        <h2 class="text-sm font-bold uppercase tracking-wide text-[#00A8FF]">Datos generales</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="tipo_proveedor" class="mb-2 block text-sm font-medium text-white">Tipo de proveedor <span class="text-[#FF2B2B]">*</span></label>
                <select id="tipo_proveedor" name="tipo_proveedor" required class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <option value="EMPRESA" <?php if(old('tipo_proveedor', $proveedor?->tipo_proveedor ?? 'EMPRESA') === 'EMPRESA'): echo 'selected'; endif; ?>>Empresa</option>
                    <option value="PERSONA" <?php if(old('tipo_proveedor', $proveedor?->tipo_proveedor) === 'PERSONA'): echo 'selected'; endif; ?>>Persona física</option>
                </select>
            </div>
            <div>
                <label for="nombre" class="mb-2 block text-sm font-medium text-white">Nombre o nombre comercial <span class="text-[#FF2B2B]">*</span></label>
                <input id="nombre" name="nombre" required maxlength="150" value="<?php echo e($valor('nombre')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="razon_social" class="mb-2 block text-sm font-medium text-white">Razón social</label>
                <input id="razon_social" name="razon_social" maxlength="200" value="<?php echo e($valor('razon_social')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['razon_social'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="rfc" class="mb-2 block text-sm font-medium text-white">RFC</label>
                <input id="rfc" name="rfc" maxlength="20" value="<?php echo e($valor('rfc')); ?>" placeholder="Se guardará en mayúsculas" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm uppercase text-white placeholder:normal-case placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['rfc'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </section>

    <section class="border-t border-white/10 pt-6">
        <h2 class="text-sm font-bold uppercase tracking-wide text-[#00A8FF]">Contacto</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="contacto" class="mb-2 block text-sm font-medium text-white">Persona de contacto</label>
                <input id="contacto" name="contacto" maxlength="150" value="<?php echo e($valor('contacto')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['contacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="telefono" class="mb-2 block text-sm font-medium text-white">Teléfono</label>
                <input id="telefono" name="telefono" type="tel" maxlength="30" value="<?php echo e($valor('telefono')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="email" class="mb-2 block text-sm font-medium text-white">Correo electrónico</label>
                <input id="email" name="email" type="email" maxlength="150" value="<?php echo e($valor('email')); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label for="sitio_web" class="mb-2 block text-sm font-medium text-white">Sitio web</label>
                <input id="sitio_web" name="sitio_web" type="url" maxlength="200" value="<?php echo e($valor('sitio_web')); ?>" placeholder="https://ejemplo.com" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                <?php $__errorArgs = ['sitio_web'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </section>

    <section class="border-t border-white/10 pt-6">
        <h2 class="text-sm font-bold uppercase tracking-wide text-[#00A8FF]">Domicilio</h2>
        <div class="mt-4 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <?php $__currentLoopData = [
                'calle' => ['Calle', 150],
                'numero_exterior' => ['Número exterior', 30],
                'numero_interior' => ['Número interior', 30],
                'colonia' => ['Colonia', 100],
                'municipio' => ['Municipio / alcaldía', 100],
                'estado' => ['Estado', 100],
                'codigo_postal' => ['Código postal', 10],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $campo => [$etiqueta, $max]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <label for="<?php echo e($campo); ?>" class="mb-2 block text-sm font-medium text-white"><?php echo e($etiqueta); ?></label>
                    <input id="<?php echo e($campo); ?>" name="<?php echo e($campo); ?>" maxlength="<?php echo e($max); ?>" value="<?php echo e($valor($campo)); ?>" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    <?php $__errorArgs = [$campo];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="border-t border-white/10 pt-6">
        <label for="notas" class="mb-2 block text-sm font-medium text-white">Notas</label>
        <textarea id="notas" name="notas" rows="3" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]"><?php echo e($valor('notas')); ?></textarea>
        <?php $__errorArgs = ['notas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="mt-1 text-xs text-[#ff7373]"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        <?php if($editando): ?>
            <label class="mt-4 inline-flex items-center gap-2 text-sm text-[#c7d0d9]">
                <input type="hidden" name="activo" value="0">
                <input type="checkbox" name="activo" value="1" <?php if(old('activo', $proveedor->activo)): echo 'checked'; endif; ?> class="rounded border-white/20 bg-[#0b1015] text-[#00A8FF] focus:ring-[#00A8FF]">
                Proveedor activo
            </label>
        <?php endif; ?>
    </section>

    <div class="flex flex-wrap justify-end gap-3 border-t border-white/10 pt-5">
        <?php if(!$editando): ?>
            <button type="reset" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Limpiar</button>
        <?php endif; ?>
        <a href="<?php echo e(route('compras.proveedores.index')); ?>" class="rounded-lg border border-white/10 px-4 py-2.5 text-sm font-semibold text-[#a7b4c1] hover:bg-white/5">Cancelar</a>
        <button type="submit" class="rounded-lg bg-[#FF2B2B] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#e51f25]"><?php echo e($editando ? 'Guardar cambios' : 'Guardar proveedor'); ?></button>
    </div>
</form>
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/compras/proveedores/_form.blade.php ENDPATH**/ ?>