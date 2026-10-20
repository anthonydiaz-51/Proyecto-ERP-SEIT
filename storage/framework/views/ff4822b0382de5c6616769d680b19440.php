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
        <h2 class="font-semibold text-xl text-white">Nuevo servicio</h2>
     <?php $__env->endSlot(); ?>

    <div
        x-data="{
            categoriaNombre: '',
            servicioNombre: <?php echo \Illuminate\Support\Js::from(old('servicio', ''))->toHtml() ?>,

            serviciosPorCategoria: {
                'Soporte técnico': [
                    'Diagnóstico de computadora',
                    'Mantenimiento preventivo',
                    'Mantenimiento correctivo',
                    'Limpieza interna y externa',
                    'Cambio de pasta térmica',
                    'Cambio de ventiladores',
                    'Cambio de disco HDD/SSD',
                    'Ampliación de memoria RAM',
                    'Instalación/cambio de fuente de poder',
                    'Reparación de problemas de encendido',
                    'Reparación de problemas de sobrecalentamiento',
                    'Optimización de rendimiento',
                    'Configuración de BIOS/UEFI',
                    'Recuperación de información',
                    'Respaldo de información',
                    'Clonación de discos',
                    'Migración HDD → SSD',
                    'Instalación de Windows',
                    'Formateo y reinstalación',
                    'Configuración inicial de Windows',
                    'Instalación de controladores',
                    'Actualización de Windows',
                    'Instalación de programas',
                    'Configuración de Microsoft Office',
                    'Instalación de antivirus',
                    'Eliminación de malware',
                    'Limpieza y optimización del sistema',
                    'Corrección de errores de software',
                    'Configuración de impresoras',
                    'Configuración de correo electrónico',
                    'Recuperación de cuentas/perfiles cuando sea técnicamente posible',
                    'Configuración de equipos nuevos',
                    'Migración de información de un equipo a otro',
                    'Otro'
                ],

                'Redes / Cableado estructurado': [
                    'Configuración de redes LAN',
                    'Configuración de Wi-Fi',
                    'Configuración de routers',
                    'Configuración de switches',
                    'Compartición de archivos e impresoras',
                    'Configuración de grupos de trabajo',
                    'Instalación de cableado de red',
                    'Ponchado de cables UTP',
                    'Certificación/prueba básica de cableado',
                    'Diagnóstico de problemas de red',
                    'Configuración de IP',
                    'Configuración de acceso remoto',
                    'Configuración de VPN',
                    'Configuración de NAS/servidores',
                    'Otro'
                ],

                'Sistemas de Seguridad': [
                    'Instalación de cámaras CCTV',
                    'Configuración de DVR/NVR',
                    'Configuración de cámaras IP',
                    'Cableado para CCTV',
                    'Configuración de acceso remoto',
                    'Instalación de discos para videograbación',
                    'Mantenimiento de cámaras',
                    'Diagnóstico de pérdida de señal',
                    'Configuración de monitoreo en celular',
                    'Instalación de alarmas',
                    'Instalación de control de acceso',
                    'Otro'
                ],

                'Diseño web / Hosting / Dominios': [
                    'Diseño Web',
                    'Redes sociales',
                    'Configuración de dominios',
                    'Configuración de hosting',
                    'Creación/configuración de cuentas de correo',
                    'Configuración de Google Workspace',
                    'Configuración de Google Business Profile',
                    'Administración básica de sitios web',
                    'Actualización de páginas web',
                    'Certificados SSL',
                    'Configuración de respaldos',
                    'Soporte de plataformas empresariales',
                    'Otro'
                ],

                'Venta equipo': ['Otro'],
                'Educación': ['Otro'],
                'Publicidad': ['Otro']
            },

            get opcionesServicio() {
                return this.serviciosPorCategoria[this.categoriaNombre] || ['Otro'];
            },

            actualizarCategoria(select) {
                this.categoriaNombre =
                    select.selectedOptions[0]?.dataset.nombre || '';

                this.servicioNombre = '';
            },

            inicializarCategoria() {
                this.categoriaNombre =
                    this.$refs.categoria.selectedOptions[0]?.dataset.nombre || '';
            },

            limpiarFormulario() {
                this.$nextTick(() => {
                    this.categoriaNombre =
                        this.$refs.categoria.selectedOptions[0]?.dataset.nombre || '';

                    this.servicioNombre = '';
                });
            }
        }"
        x-init="inicializarCategoria()"
        class="max-w-3xl mx-auto py-6"
    >
        <div class="bg-white shadow rounded-lg p-6">
            <form
                method="POST"
                action="<?php echo e(route('comercial.servicios.store')); ?>"
                @reset="limpiarFormulario()"
            >
                <?php echo csrf_field(); ?>

                <div class="mb-4">
                    <label
                        for="categoria_id"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Categoría
                    </label>

                    <select
                        id="categoria_id"
                        name="categoria_id"
                        x-ref="categoria"
                        @change="actualizarCategoria($event.target)"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300"
                    >
                        <option
                            value=""
                            data-nombre=""
                            <?php echo e(old('categoria_id') ? '' : 'selected'); ?>

                        >
                            -- Selecciona una categoría --
                        </option>

                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($categoria->id); ?>"
                                data-nombre="<?php echo e($categoria->nombre); ?>"
                                <?php echo e(old('categoria_id') == $categoria->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($categoria->nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <?php $__errorArgs = ['categoria_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label
                        for="servicio"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Servicio
                    </label>

                    <select
                        id="servicio"
                        name="servicio"
                        x-model="servicioNombre"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300"
                    >
                        <option value="">-- Selecciona un servicio --</option>

                        <template x-for="opcion in opcionesServicio" :key="opcion">
                            <option :value="opcion" x-text="opcion"></option>
                        </template>
                    </select>

                    <?php $__errorArgs = ['servicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="mb-4">
                    <label
                        for="descripcion"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="3"
                        placeholder="Si seleccionaste “Otro”, describe aquí el servicio."
                        class="mt-1 block w-full rounded-md border-gray-300"
                    ><?php echo e(old('descripcion')); ?></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label
                            for="precio_base"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Precio base
                        </label>

                        <input
                            id="precio_base"
                            type="number"
                            step="0.01"
                            min="0"
                            name="precio_base"
                            value="<?php echo e(old('precio_base')); ?>"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >

                        <?php $__errorArgs = ['precio_base'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div>
                        <label
                            for="tipo_precio"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Tipo de precio
                        </label>

                        <input
                            id="tipo_precio"
                            type="text"
                            name="tipo_precio"
                            value="<?php echo e(old('tipo_precio')); ?>"
                            placeholder="FIJO, POR_HORA, POR_EQUIPO..."
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >
                    </div>
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="promocion"
                            value="1"
                            <?php echo e(old('promocion') ? 'checked' : ''); ?>

                        >

                        <span class="ml-2 text-sm text-gray-700">
                            Marcar como promoción
                        </span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="reset"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100"
                    >
                        Limpiar
                    </button>

                    <a
                        href="<?php echo e(route('comercial.servicios.index')); ?>"
                        class="px-4 py-2 text-sm text-gray-600"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700"
                    >
                        Guardar servicio
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
<?php endif; ?><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/comercial/servicios/create.blade.php ENDPATH**/ ?>