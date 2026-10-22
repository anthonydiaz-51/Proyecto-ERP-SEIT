<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'ERP SEIT')); ?></title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="seit-app-shell flex min-h-screen">
            <div
                x-show="sidebarOpen"
                x-cloak
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-30 bg-black/70 backdrop-blur-sm lg:hidden"
                aria-hidden="true"
            ></div>
            <?php if (isset($component)) { $__componentOriginal2880b66d47486b4bfeaf519598a469d6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2880b66d47486b4bfeaf519598a469d6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $attributes = $__attributesOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__attributesOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2880b66d47486b4bfeaf519598a469d6)): ?>
<?php $component = $__componentOriginal2880b66d47486b4bfeaf519598a469d6; ?>
<?php unset($__componentOriginal2880b66d47486b4bfeaf519598a469d6); ?>
<?php endif; ?>

            <div class="flex-1 flex flex-col">
                <header class="seit-topbar sticky top-0 z-20 flex items-center justify-between px-5 py-3 sm:px-8">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <a href="<?php echo e(route('dashboard')); ?>" class="inline-flex items-center rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A8FF]" aria-label="Ir al inicio de SEIT">
                            <img src="<?php echo e(asset('images/logo-seit-SinFondo-Oscuro.png')); ?>" alt="SEIT GDL, Soluciones en Tecnología" class="h-[62px] w-auto object-contain sm:h-[64px]">
                        </a>
                        <button
                            type="button"
                            @click="sidebarOpen = !sidebarOpen"
                            :aria-label="sidebarOpen ? 'Cerrar menú' : 'Abrir menú'"
                            :aria-expanded="sidebarOpen"
                            aria-controls="app-sidebar"
                            title="Menú"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-white/10 text-gray-300 transition hover:border-[#00A8FF]/50 hover:bg-[#00A8FF]/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-[#00A8FF]"
                        >
                            <span class="sr-only">Menú</span>
                            <span class="flex w-5 flex-col gap-1" aria-hidden="true">
                                <span class="h-0.5 w-full bg-current"></span>
                                <span class="h-0.5 w-full bg-current"></span>
                                <span class="h-0.5 w-full bg-current"></span>
                            </span>
                        </button>
                    </div>
                    <div class="flex items-center gap-3 rounded-full border border-white/10 bg-white/[0.04] py-1.5 pl-2 pr-4">
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#00A8FF]/15 text-sm font-bold text-[#00A8FF]">
                            <?php echo e(mb_strtoupper(mb_substr(auth()->user()->nombre ?? 'S', 0, 1) . mb_substr(auth()->user()->apellido ?? '', 0, 1))); ?>

                        </span>
                        <span class="text-sm font-medium text-white">
                            <?php echo e(auth()->user()->nombre); ?> <?php echo e(auth()->user()->apellido); ?>

                        </span>
                    </div>
                </header>

                <?php if(isset($header)): ?>
                    <div class="seit-page-header px-6 py-5 sm:px-8">
                        <?php echo e($header); ?>

                    </div>
                <?php endif; ?>

                <main class="seit-main flex-1 p-6 sm:p-8">
                    <?php echo e($slot); ?>

                </main>
            </div>
        </div>
    </body>
</html>
<?php /**PATH /Users/anthonydiaz/Documents/Projecto_ERP_Seit/erp-seit-backend/resources/views/layouts/app.blade.php ENDPATH**/ ?>