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
        <?php if(session('error')): ?>
            <div class="max-w-4xl mx-auto mt-4">
                <div class="bg-red-50 text-red-700 px-4 py-3 rounded-md text-sm"><?php echo e(session('error')); ?></div>
            </div>
        <?php endif; ?>
        <h2 class="font-semibold text-xl text-gray-800">Editar cotización — <?php echo e($cotizacion->folio); ?></h2>
     <?php $__env->endSlot(); ?>

    <div
        x-data="{
            lineas: <?php echo e($cotizacion->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'tipo_descuento' => 'FIJO',
                'descuento' => $d->descuento,
            ])->values()); ?>,

            servicios: <?php echo \Illuminate\Support\Js::from($servicios->map(fn($servicio) => [
                'id' => $servicio->id,
                'nombre' => $servicio->servicio,
                'precio' => $servicio->precio_base
            ])->values())->toHtml() ?>,

            lineasOriginales: <?php echo e($cotizacion->detalles->map(fn($d) => [
                'servicio_id' => $d->servicio_id,
                'cantidad' => $d->cantidad,
                'precio_unitario' => $d->precio_unitario,
                'tipo_descuento' => 'FIJO',
                'descuento' => $d->descuento,
            ])->values()); ?>,

            agregarLinea() {
                this.lineas.push({
                    servicio_id: '',
                    cantidad: 1,
                    precio_unitario: 0,
                    tipo_descuento: 'FIJO',
                    descuento: 0
                });
            },

            quitarLinea(index) {
                if (this.lineas.length > 1) {
                    this.lineas.splice(index, 1);
                }
            },

            autocompletarPrecio(index) {
                const servicioId = this.lineas[index].servicio_id;
                const servicio = this.servicios.find(
                    item => item.id == servicioId
                );

                this.lineas[index].precio_unitario = servicio
                    ? servicio.precio
                    : 0;
            },

            montoDescuento(linea) {
                const cantidad = Number(linea.cantidad) || 0;
                const precio = Number(linea.precio_unitario) || 0;
                const descuento = Number(linea.descuento) || 0;
                const importeBruto = cantidad * precio;

                return linea.tipo_descuento === 'PORCENTAJE'
                    ? importeBruto * descuento / 100
                    : descuento;
            },

            subtotalLinea(linea) {
                const cantidad = Number(linea.cantidad) || 0;
                const precio = Number(linea.precio_unitario) || 0;
                const importeBruto = cantidad * precio;

                return importeBruto - this.montoDescuento(linea);
            },

            get subtotal() {
                return this.lineas.reduce(
                    (acumulado, linea) =>
                        acumulado + this.subtotalLinea(linea),
                    0
                );
            },

            get impuestos() {
                return this.subtotal * 0.16;
            },

            get total() {
                return this.subtotal + this.impuestos;
            },

            limpiarFormulario() {
                this.$nextTick(() => {
                    this.lineas = JSON.parse(JSON.stringify(this.lineasOriginales));
                });
            }
        }"
        class="max-w-4xl mx-auto py-6"
    >
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="<?php echo e(route('comercial.cotizaciones.update', $cotizacion)); ?>" @reset="limpiarFormulario()">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <div class="grid grid-cols-3 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Cliente</label>
                        <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cliente->id); ?>" <?php echo e(old('cliente_id', $cotizacion->cliente_id) == $cliente->id ? 'selected' : ''); ?>>
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
                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                        <input type="date" name="fecha" value="<?php echo e(old('fecha', $cotizacion->fecha)); ?>"
                               class="mt-1 block w-full rounded-md border-gray-300">
                        <?php $__errorArgs = ['fecha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado</label>
                        <select name="estado" class="mt-1 block w-full rounded-md border-gray-300">
                            <?php $__currentLoopData = ['PENDIENTE', 'ACEPTADA', 'RECHAZADA', 'VENCIDA', 'CANCELADA']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($estado); ?>" <?php echo e(old('estado', $cotizacion->estado) == $estado ? 'selected' : ''); ?>>
                                    <?php echo e($estado); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Vigencia (opcional)</label>
                    <input type="date" name="vigencia" value="<?php echo e(old('vigencia', $cotizacion->vigencia)); ?>"
                           class="mt-1 block w-48 rounded-md border-gray-300">
                </div>

                <h3 class="font-medium text-gray-700 mb-2">Servicios cotizados</h3>

                <template x-for="(linea, index) in lineas" :key="index">
                    <div class="grid grid-cols-12 gap-2 mb-2 items-start">
                        <div class="col-span-3">
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
                            <input type="number" step="1.00" min="0" :name="'lineas[' + index + '][cantidad]'"
                                   x-model.number="linea.cantidad" placeholder="Cantidad"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <input type="number" step="0.01" min="0" :name="'lineas[' + index + '][precio_unitario]'"
                                   x-model.number="linea.precio_unitario" placeholder="Precio"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        <div class="col-span-2">
                            <select :name="'lineas[' + index + '][tipo_descuento]'" x-model="linea.tipo_descuento"
                                    class="block w-full rounded-md border-gray-300 text-sm">
                                <option value="FIJO">Fijo ($)</option>
                                <option value="PORCENTAJE">Porcentaje (%)</option>
                            </select>
                        </div>
                        <div class="col-span-3">
                            <input type="number" step="1.00" min="0"
                                   :max="linea.tipo_descuento === 'PORCENTAJE' ? 100 : null"
                                   :name="'lineas[' + index + '][descuento]'"
                                   x-model.number="linea.descuento"
                                   :placeholder="linea.tipo_descuento === 'PORCENTAJE' ? '%' : '$'"
                                   class="block w-full rounded-md border-gray-300 text-sm">
                        </div>
                        
                            <button type="button" @click="quitarLinea(index)" class="text-red-500 text-sm" aria-label="Quitar línea">✕</button>
                        </div>
                    </div>
                </template>

                <button type="button" @click="agregarLinea()" class="text-indigo-600 text-sm mb-6">
                    + Agregar línea
                </button>
                <?php $__errorArgs = ['lineas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-500 text-sm mb-4"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <div class="border-t pt-4 mb-6 text-right text-sm text-gray-700 space-y-1">
                    <p>Subtotal: $<span x-text="subtotal.toFixed(2)"></span></p>
                    <p>Impuestos (16%): $<span x-text="impuestos.toFixed(2)"></span></p>
                    <p class="font-semibold text-base">Total: $<span x-text="total.toFixed(2)"></span></p>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                    <textarea name="observaciones" rows="2" class="mt-1 block w-full rounded-md border-gray-300"><?php echo e(old('observaciones', $cotizacion->observaciones)); ?></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="reset" class="px-4 py-2 text-sm text-gray-600">
                        Limpiar
                    </button>
                    <a href="<?php echo e(route('comercial.cotizaciones.index')); ?>" class="px-4 py-2 text-sm text-gray-600">Cancelar</a>
                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                        Guardar cambios
                    </button>
                </div>
            </form>

            <form method="POST" action="<?php echo e(route('comercial.cotizaciones.destroy', $cotizacion)); ?>"
                  onsubmit="return confirm('¿Cancelar esta cotización?');" class="mt-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="text-red-600 text-sm hover:underline">Cancelar cotización</button>
            </form>
            
        <?php if($cotizacion->estado === 'ACEPTADA'): ?>
            <?php
                $ordenActiva = $cotizacion->ordenes->where('estado', '!=', 'CANCELADO')->first();
            ?>

            <div class="border-t mt-6 pt-4">
                <?php if($ordenActiva): ?>
                    <p class="text-sm text-gray-600">
                        Esta cotización ya generó la orden
                        <a href="<?php echo e(route('sistemas.ordenes.edit', $ordenActiva)); ?>" class="text-indigo-600 hover:underline"><?php echo e($ordenActiva->folio); ?></a>.
                    </p>
                <?php else: ?>
                    <form method="POST" action="<?php echo e(route('comercial.cotizaciones.generar-orden', $cotizacion)); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="bg-teal-600 text-white px-4 py-2 rounded-md text-sm hover:bg-teal-700">
                            Generar orden de servicio
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; ?>
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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/comercial/cotizaciones/edit.blade.php ENDPATH**/ ?>