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
        <?php if(session('success')): ?>
            <div class="max-w-4xl mx-auto mt-4">
                <div class="bg-green-50 text-green-700 px-4 py-3 rounded-md text-sm"><?php echo e(session('success')); ?></div>
            </div>
        <?php endif; ?>

        <?php if($orden->cotizacion): ?>
            <div class="max-w-4xl mx-auto mt-4 text-sm text-gray-600">
                Generada desde la cotización
                <a href="<?php echo e(route('comercial.cotizaciones.edit', $orden->cotizacion)); ?>" class="text-indigo-600 hover:underline"><?php echo e($orden->cotizacion->folio); ?></a>.
            </div>
        <?php endif; ?>
        <h2 class="font-semibold text-xl text-white">Editar orden — <?php echo e($orden->folio); ?></h2>
     <?php $__env->endSlot(); ?>

    <div
        x-data="{
            lineas: <?php echo e($orden->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'descuento' => $d->descuento,
            ])->values()); ?>,
            lineasOriginales: <?php echo e($orden->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'descuento' => $d->descuento,
            ])->values()); ?>,
            servicios: <?php echo \Illuminate\Support\Js::from($servicios->map(fn($s) => ['id' => $s->id, 'nombre' => $s->servicio, 'precio' => $s->precio_base])->values())->toHtml() ?>,
            agregarLinea() {
                this.lineas.push({ servicio_id: '', cantidad: 1, precio_unitario: 0, descuento: 0 });
            },
            quitarLinea(index) {
                this.lineas.splice(index, 1);
            },
            autocompletarPrecio(index) {
                const servicio = this.servicios.find(s => s.id == this.lineas[index].servicio_id);
                this.lineas[index].precio_unitario = servicio ? servicio.precio : 0;
            },
            subtotalLinea(linea) {
                return (linea.cantidad * linea.precio_unitario) - (linea.descuento || 0);
            },
            get costoTotal() {
                return this.lineas.reduce((acc, l) => acc + this.subtotalLinea(l), 0);
            },
            limpiarFormulario() {
                this.$nextTick(() => { this.lineas = JSON.parse(JSON.stringify(this.lineasOriginales)); });
            }
        }"
        class="max-w-4xl mx-auto py-6"
    >
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="<?php echo e(route('sistemas.ordenes.update', $orden)); ?>" @reset="limpiarFormulario()">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id', $orden->cliente_id) == $cliente->id ? 'selected' : ''); ?>>
                                    <?php echo e($cliente->nombre); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['cliente_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Técnico asignado</label>
                        <select name="tecnico_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">-- Sin asignar --</option>
                            <?php $__currentLoopData = $tecnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tecnico): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($tecnico->id); ?>" <?php echo e(old('tecnico_id', $orden->tecnico_id) == $tecnico->id ? 'selected' : ''); ?>>
                                    <?php echo e($tecnico->nombre); ?> <?php echo e($tecnico->apellido); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 block w-full rounded-md border-gray-300">
                            <?php $__currentLoopData = ['RECIBIDO','DIAGNOSTICO','COTIZACION','AUTORIZADO','EN_PROCESO','LISTO','ENTREGADO','CANCELADO']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado); ?>" <?php echo e(old('estado', $orden->estado) == $estado ? 'selected' : ''); ?>>
                                    <?php echo e($estado); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de recepción</label>
                        <input type="date" name="fecha_recepcion" value="<?php echo e(old('fecha_recepcion', $orden->fecha_recepcion)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha compromiso</label>
                        <input type="date" name="fecha_compromiso" value="<?php echo e(old('fecha_compromiso', $orden->fecha_compromiso)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha entrega</label>
                        <input type="date" name="fecha_entrega" value="<?php echo e(old('fecha_entrega', $orden->fecha_entrega)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Prioridad</label>
                    <select name="prioridad" class="mt-1 block w-48 rounded-md border-gray-300">
                        <?php $__currentLoopData = ['BAJA', 'MEDIA', 'ALTA', 'URGENTE']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prioridad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($prioridad); ?>" <?php echo e(old('prioridad', $orden->prioridad) == $prioridad ? 'selected' : ''); ?>>
                                <?php echo e($prioridad); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Descripción de la falla</label>
                    <textarea name="descripcion_falla" rows="2" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('descripcion_falla', $orden->descripcion_falla)); ?></textarea>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Diagnóstico</label>
                    <textarea name="diagnostico" rows="2" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('diagnostico', $orden->diagnostico)); ?></textarea>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Solución</label>
                    <textarea name="solucion" rows="2" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('solucion', $orden->solucion)); ?></textarea>
                </div>

                <h3 class="font-medium text-gray-700 mb-2">Servicios realizados</h3>

                <template x-for="(linea, index) in lineas" :key="index">
                    <div class="grid grid-cols-12 gap-2 mb-2 items-start">
                        <div class="col-span-5">
                            <select :name="'lineas[' + index + '][servicio_id]'" x-model="linea.servicio_id"
                                    @change="autocompletarPrecio(index)"
                                    class="block w-full rounded-md border-gray-300 text-sm">
                                <option value="">-- Servicio --</option>
                                <?php $__currentLoopData = $servicios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $servicio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($servicio->id); ?>"><?php echo e($servicio->servicio); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="1" min="0" :name="'lineas[' + index + '][cantidad]'"
                                   x-model.number="linea.cantidad" placeholder="Cantidad"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="0.01" min="0" :name="'lineas[' + index + '][precio_unitario]'"
                                   x-model.number="linea.precio_unitario" placeholder="Precio"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="0.01" min="0" :name="'lineas[' + index + '][descuento]'"
                                   x-model.number="linea.descuento" placeholder="Descuento"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-1">
                            <button type="button" @click="quitarLinea(index)" class="text-red-500 text-sm">✕</button>
                        </div>
                    </div>
                </template>

                <button type="button" @click="agregarLinea()" class="text-indigo-600 text-sm mb-6">
                    + Agregar servicio
                </button>

                <div class="border-t pt-4 mb-6 text-right text-sm text-gray-700">
                    <p class="font-semibold text-base">Costo total: $<span x-text="costoTotal.toFixed(2)"></span></p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('observaciones', $orden->observaciones)); ?></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset" class="px-4 py-2 text-sm text-gray-600">Limpiar</button>
                    <a href="<?php echo e(route('sistemas.ordenes.index')); ?>" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            <form method="POST" action="<?php echo e(route('sistemas.ordenes.destroy', $orden)); ?>"
                  onsubmit="return confirm('¿Cancelar esta orden de servicio?');" class="mt-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-red-600 text-sm hover:underline">Cancelar orden</button>
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
<?php endif; ?>

<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/sistemas/ordenes-servicio/edit.blade.php ENDPATH**/ ?>