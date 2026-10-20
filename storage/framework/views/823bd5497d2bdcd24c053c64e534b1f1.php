<?php
    $rolId = auth()->user()?->rol_id;
?>

<aside
    x-data="{ open: { admin: true, comercial: true, finanzas: true, sistemas: true, rh: false, practicas: false, cursos: false } }"
    x-show="sidebarOpen"
    x-cloak
    x-transition:enter="transform transition ease-in-out duration-200"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transform transition ease-in-out duration-200"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    id="app-sidebar"
    class="fixed inset-y-0 left-0 z-40 flex min-h-screen w-64 flex-col border-r border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-800"
>
    <div class="flex items-center justify-between border-b border-gray-200 p-4 dark:border-gray-700">
        <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Búsqueda en el menú</span>
        <button
            type="button"
            @click="sidebarOpen = false"
            aria-label="Cerrar menú"
            title="Cerrar menú"
            class="inline-flex h-8 w-8 items-center justify-center rounded-md text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:hover:bg-gray-700"
        >
            <span aria-hidden="true" class="text-xl leading-none">&times;</span>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto py-2">

        
        <?php if(in_array($rolId, [1, 2])): ?>
        <div class="px-3 py-2">
            <button @click="open.admin = !open.admin" class="flex items-center justify-between w-full text-xs font-semibold text-gray-500 uppercase tracking-wide px-2 py-1">
                <span>Administración</span>
                <span x-text="open.admin ? '−' : '+'"></span>
            </button>
            <div x-show="open.admin" class="mt-1 space-y-1">
                <a href="<?php echo e(route('administracion.usuarios.index')); ?>"
                   class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('administracion.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Usuarios
                </a>
            </div>
        </div>
        <?php endif; ?>

        
        <div class="px-3 py-2">
            <button @click="open.comercial = !open.comercial" class="flex items-center justify-between w-full text-xs font-semibold text-gray-500 uppercase tracking-wide px-2 py-1">
                <span>Comercial</span>
                <span x-text="open.comercial ? '−' : '+'"></span>
            </button>
            <div x-show="open.comercial" class="mt-1 space-y-1">
                <a href="<?php echo e(route('comercial.clientes.index')); ?>"
                   class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('comercial.clientes.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Clientes
                </a>
                <a href="<?php echo e(route('comercial.cotizaciones.index')); ?>"
                   class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('comercial.cotizaciones.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Cotizaciones
                </a>
                <a href="<?php echo e(route('comercial.servicios.index')); ?>"
                   class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('comercial.servicios.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Servicios
                </a>
                <a href="<?php echo e(route('comercial.ventas.index')); ?>"
                class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('comercial.ventas.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Ventas
                </a>
            </div>
        </div>

        
        <div class="px-3 py-2">
            <button @click="open.finanzas = !open.finanzas" class="flex items-center justify-between w-full text-xs font-semibold text-gray-500 uppercase tracking-wide px-2 py-1">
                <span>Finanzas</span>
                <span x-text="open.finanzas ? '−' : '+'"></span>
            </button>
            <div x-show="open.finanzas" class="mt-1 space-y-1">
                <a href="<?php echo e(route('finanzas.pagos.index')); ?>"
                   class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('finanzas.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Pagos
                </a>
            </div>
        </div>

        
        <div class="px-3 py-2">
            <button @click="open.sistemas = !open.sistemas" class="flex items-center justify-between w-full text-xs font-semibold text-gray-500 uppercase tracking-wide px-2 py-1">
                <span>Sistemas</span>
                <span x-text="open.sistemas ? '−' : '+'"></span>
            </button>
            <div x-show="open.sistemas" class="mt-1 space-y-1">
                <a href="<?php echo e(route('sistemas.ordenes.index')); ?>"
                   class="flex items-center gap-2 px-3 py-2 text-sm rounded-md <?php echo e(request()->routeIs('sistemas.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-50'); ?>">
                    Tickets / Órdenes de Servicio
                </a>
            </div>
        </div>

        
        <?php $__currentLoopData = [
            'rh' => 'RH',
            'practicas' => 'Prácticas profesionales',
            'cursos' => 'Cursos',
        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="px-3 py-2">
            <a href="<?php echo e(route('modulo.pendiente', $key)); ?>"
               class="flex items-center justify-between w-full text-xs font-semibold text-gray-400 uppercase tracking-wide px-2 py-2">
                <span><?php echo e($label); ?></span>
                <span class="text-[10px] normal-case bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Próximamente</span>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </nav>

    <div class="p-3 border-t border-gray-200 dark:border-gray-700">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="w-full text-left text-sm text-gray-600 hover:text-red-600 px-2 py-2">
                Cerrar Sesión
            </button>
        </form>
    </div>
</aside><?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/components/sidebar.blade.php ENDPATH**/ ?>