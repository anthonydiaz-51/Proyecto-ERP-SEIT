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
                <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Almacén SEIT</p>
                <h1 class="mt-1 text-2xl font-semibold text-white">Inventario</h1>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('inventario.movimientos.index')); ?>" class="rounded-lg border border-[#00A8FF]/30 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#00A8FF]/10">Historial de movimientos</a>
                <a href="<?php echo e(route('inventario.movimientos.create')); ?>" class="rounded-lg border border-white/15 px-4 py-2.5 text-sm font-semibold text-white transition hover:border-[#00A8FF]/50 hover:bg-[#00A8FF]/10">Registrar movimiento</a>
                <a href="<?php echo e(route('inventario.productos.create')); ?>" class="rounded-lg bg-[#FF2B2B] px-4 py-2.5 text-sm font-bold text-white transition hover:bg-[#e51f25]">+ Nuevo producto</a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="mb-5 rounded-lg border border-[#00A8FF]/30 bg-[#00A8FF]/10 px-4 py-3 text-sm text-white" role="status"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="mx-auto max-w-[1600px] space-y-6">
        <section class="relative overflow-hidden rounded-2xl border border-[#00A8FF]/20 bg-gradient-to-r from-[#111820] via-[#101820] to-[#171015] p-6 sm:p-8">
            <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full bg-[#00A8FF]/10 blur-3xl"></div>
            <div class="relative flex flex-col justify-between gap-6 lg:flex-row lg:items-center">
                <div class="max-w-2xl">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#FF2B2B]">Control de existencias</p>
                    <h2 class="mt-2 text-2xl font-semibold text-white sm:text-3xl">Catálogo de productos</h2>
                    <p class="mt-2 text-sm leading-6 text-[#a7b4c1]">Busca productos, revisa sus niveles de stock y registra cada entrada, salida o ajuste para conservar el historial.</p>
                </div>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4 lg:min-w-[580px]">
                    <div class="rounded-xl border border-white/10 bg-black/20 p-3"><p class="text-xs text-[#a7b4c1]">Productos activos</p><p class="mt-1 text-2xl font-bold text-white"><?php echo e(number_format($totalProductos)); ?></p></div>
                    <div class="rounded-xl border border-white/10 bg-black/20 p-3"><p class="text-xs text-[#a7b4c1]">Unidades en stock</p><p class="mt-1 text-2xl font-bold text-[#00A8FF]"><?php echo e(number_format((float) $unidadesEnStock, 2)); ?></p></div>
                    <div class="rounded-xl border border-white/10 bg-black/20 p-3"><p class="text-xs text-[#a7b4c1]">Stock bajo</p><p class="mt-1 text-2xl font-bold text-amber-300"><?php echo e(number_format($stockBajo)); ?></p></div>
                    <div class="rounded-xl border border-white/10 bg-black/20 p-3"><p class="text-xs text-[#a7b4c1]">Sin existencia</p><p class="mt-1 text-2xl font-bold text-[#FF2B2B]"><?php echo e(number_format($sinExistencia)); ?></p></div>
                </div>
            </div>
        </section>

        <div class="grid gap-5 xl:grid-cols-[260px_minmax(0,1fr)]">
            <aside class="h-fit rounded-2xl border border-[#00A8FF]/15 bg-[#111820] p-5">
                <div class="mb-5 flex items-center justify-between">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-white">Filtrar catálogo</h2>
                    <a href="<?php echo e(route('inventario.index')); ?>" class="text-xs font-semibold text-[#00A8FF] hover:underline">Limpiar</a>
                </div>
                <form method="GET" action="<?php echo e(route('inventario.index')); ?>" class="space-y-5">
                    <div>
                        <label for="q" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Buscar producto</label>
                        <input id="q" name="q" type="search" value="<?php echo e(request('q')); ?>" placeholder="Nombre, código o descripción" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white placeholder:text-[#73808d] focus:border-[#00A8FF] focus:outline-none focus:ring-1 focus:ring-[#00A8FF]">
                    </div>
                    <div>
                        <label for="categoria_id" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Categoría</label>
                        <select id="categoria_id" name="categoria_id" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                            <option value="">Todas las categorías</option>
                            <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id); ?>" <?php if((string) request('categoria_id') === (string) $categoria->id): echo 'selected'; endif; ?>><?php echo e($categoria->nombre); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label for="stock" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Disponibilidad</label>
                        <select id="stock" name="stock" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                            <option value="">Cualquier existencia</option>
                            <option value="disponible" <?php if(request('stock') === 'disponible'): echo 'selected'; endif; ?>>En existencia</option>
                            <option value="bajo" <?php if(request('stock') === 'bajo'): echo 'selected'; endif; ?>>Stock bajo</option>
                            <option value="agotado" <?php if(request('stock') === 'agotado'): echo 'selected'; endif; ?>>Sin existencia</option>
                        </select>
                    </div>
                    <div>
                        <label for="orden" class="mb-2 block text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Ordenar por</label>
                        <select id="orden" name="orden" class="w-full rounded-lg border border-white/10 bg-[#0b1015] px-3 py-2.5 text-sm text-white focus:border-[#00A8FF] focus:outline-none">
                            <option value="nombre" <?php if(request('orden', 'nombre') === 'nombre'): echo 'selected'; endif; ?>>Nombre A–Z</option>
                            <option value="nombre_desc" <?php if(request('orden') === 'nombre_desc'): echo 'selected'; endif; ?>>Nombre Z–A</option>
                            <option value="codigo" <?php if(request('orden') === 'codigo'): echo 'selected'; endif; ?>>Código</option>
                            <option value="stock_asc" <?php if(request('orden') === 'stock_asc'): echo 'selected'; endif; ?>>Menor existencia</option>
                            <option value="stock_desc" <?php if(request('orden') === 'stock_desc'): echo 'selected'; endif; ?>>Mayor existencia</option>
                            <option value="precio_asc" <?php if(request('orden') === 'precio_asc'): echo 'selected'; endif; ?>>Precio: menor a mayor</option>
                            <option value="precio_desc" <?php if(request('orden') === 'precio_desc'): echo 'selected'; endif; ?>>Precio: mayor a menor</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full rounded-lg bg-[#00A8FF] px-4 py-2.5 text-sm font-bold text-[#0D0D0D] transition hover:bg-[#008bd1]">Aplicar filtros</button>
                </form>

                <div class="mt-6 border-t border-white/10 pt-5">
                    <p class="text-xs font-semibold uppercase tracking-wide text-[#a7b4c1]">Actividad de hoy</p>
                    <p class="mt-2 text-2xl font-bold text-white"><?php echo e(number_format($movimientosRecientes)); ?></p>
                    <p class="text-xs text-[#81909e]">movimientos registrados</p>
                    <a href="<?php echo e(route('inventario.movimientos.index')); ?>" class="mt-3 inline-flex text-xs font-semibold text-[#00A8FF] hover:underline">Ver historial →</a>
                </div>
            </aside>

            <section aria-label="Productos del inventario">
                <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-semibold text-white"><?php echo e($productos->total()); ?> productos</p>
                        <p class="text-xs text-[#81909e]">El stock se actualiza desde el registro de movimientos.</p>
                    </div>
                    <a href="<?php echo e(route('inventario.movimientos.create')); ?>" class="text-sm font-semibold text-[#00A8FF] hover:underline">+ Entrada, salida o ajuste</a>
                </div>

                <?php if($productos->count()): ?>
                    <div class="grid gap-4 sm:grid-cols-2 2xl:grid-cols-3">
                        <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $existencia = (float) ($producto->inventario?->existencia ?? 0);
                                $minimo = (int) ($producto->stock_minimo ?? 0);
                                $agotado = $existencia <= 0;
                                $stockBajoProducto = !$agotado && $minimo > 0 && $existencia <= $minimo;
                            ?>
                            <article class="group flex min-h-[290px] flex-col overflow-hidden rounded-2xl border border-white/10 bg-[#111820] transition hover:-translate-y-0.5 hover:border-[#00A8FF]/45 hover:shadow-[0_16px_36px_rgba(0,168,255,0.08)]">
                                <div class="relative flex h-36 items-center justify-center overflow-hidden border-b border-white/5 bg-[radial-gradient(ellipse_at_center,rgba(0,168,255,0.12),transparent_65%),#0d1116]">
                                    <div class="absolute left-4 top-4 rounded-md border border-[#00A8FF]/20 bg-[#00A8FF]/10 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-[#80d6ff]"><?php echo e($producto->categoria?->nombre ?? 'Sin categoría'); ?></div>
                                    <?php if($agotado): ?>
                                        <span class="absolute right-3 top-3 rounded-full bg-[#FF2B2B]/15 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#ff7373]">Agotado</span>
                                    <?php elseif($stockBajoProducto): ?>
                                        <span class="absolute right-3 top-3 rounded-full bg-amber-400/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-amber-300">Stock bajo</span>
                                    <?php else: ?>
                                        <span class="absolute right-3 top-3 rounded-full bg-[#00A8FF]/10 px-2.5 py-1 text-[10px] font-bold uppercase tracking-wide text-[#80d6ff]">Disponible</span>
                                    <?php endif; ?>
                                    <svg class="h-16 w-16 text-[#00A8FF]/80 transition group-hover:scale-105" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.1" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4-8 4-8-4Zm0 0v10l8 4 8-4V7m-8 4v10" /><path stroke-linecap="round" stroke-linejoin="round" d="m8 5 8 4" /></svg>
                                    <span class="absolute bottom-3 right-4 text-[10px] font-bold uppercase tracking-[0.18em] text-white/25">SEIT · STOCK</span>
                                </div>
                                <div class="flex flex-1 flex-col p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <h3 class="line-clamp-2 font-semibold leading-5 text-white"><?php echo e($producto->nombre); ?></h3>
                                            <p class="mt-1 truncate text-xs font-medium tracking-wide text-[#a7b4c1]"><?php echo e($producto->codigo ?: 'Sin código'); ?></p>
                                        </div>
                                        <div class="shrink-0 text-right">
                                            <p class="text-[10px] uppercase tracking-wide text-[#81909e]">Existencia</p>
                                            <p class="text-lg font-bold <?php echo e($agotado ? 'text-[#FF2B2B]' : ($stockBajoProducto ? 'text-amber-300' : 'text-[#00A8FF]')); ?>"><?php echo e(number_format($existencia, 2)); ?></p>
                                        </div>
                                    </div>
                                    <p class="mt-3 line-clamp-2 min-h-10 text-xs leading-5 text-[#a7b4c1]"><?php echo e($producto->descripcion ?: 'Sin descripción registrada.'); ?></p>
                                    <div class="mt-3 grid grid-cols-2 gap-2 border-t border-white/10 pt-3 text-xs">
                                        <div><p class="text-[#81909e]">Precio venta</p><p class="mt-0.5 font-semibold text-white"><?php echo e($producto->precio_venta !== null ? '$'.number_format((float) $producto->precio_venta, 2) : '—'); ?></p></div>
                                        <div><p class="text-[#81909e]">Stock mínimo</p><p class="mt-0.5 font-semibold text-white"><?php echo e(number_format($minimo)); ?></p></div>
                                        <div class="col-span-2"><p class="text-[#81909e]">Ubicación</p><p class="mt-0.5 truncate font-medium text-white"><?php echo e($producto->inventario?->ubicacion ?: 'Sin ubicación'); ?></p></div>
                                    </div>
                                    <div class="mt-auto flex gap-2 pt-4">
                                        <a href="<?php echo e(route('inventario.productos.edit', $producto)); ?>" class="flex-1 rounded-lg border border-white/10 px-3 py-2 text-center text-xs font-semibold text-white transition hover:border-[#00A8FF]/40 hover:bg-[#00A8FF]/10">Editar</a>
                                        <a href="<?php echo e(route('inventario.movimientos.create', ['producto_id' => $producto->id])); ?>" class="flex-1 rounded-lg bg-[#00A8FF]/10 px-3 py-2 text-center text-xs font-bold text-[#00A8FF] transition hover:bg-[#00A8FF] hover:text-[#0D0D0D]">Mover stock</a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mt-6"><?php echo e($productos->links()); ?></div>
                <?php else: ?>
                    <div class="rounded-2xl border border-dashed border-[#00A8FF]/25 bg-[#111820] px-6 py-16 text-center">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#00A8FF]/10 text-[#00A8FF]"><svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="m4 7 8-4 8 4-8 4-8-4Zm0 0v10l8 4 8-4V7m-8 4v10" /></svg></div>
                        <h3 class="mt-4 text-lg font-semibold text-white">No hay productos para mostrar</h3>
                        <p class="mt-1 text-sm text-[#a7b4c1]">Prueba otros filtros o agrega el primer producto al inventario.</p>
                        <a href="<?php echo e(route('inventario.productos.create')); ?>" class="mt-5 inline-flex rounded-lg bg-[#FF2B2B] px-4 py-2.5 text-sm font-bold text-white hover:bg-[#e51f25]">Agregar producto</a>
                    </div>
                <?php endif; ?>
            </section>
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
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/inventario/index.blade.php ENDPATH**/ ?>