<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'ERP SEIT') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <x-sidebar />

            <div class="flex-1 flex flex-col">
                <header class="seit-topbar sticky top-0 z-20 flex items-center justify-between px-5 py-3 sm:px-8">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center rounded-md focus:outline-none focus:ring-2 focus:ring-[#00A8FF]" aria-label="Ir al inicio de SEIT">
                            <img src="{{ asset('images/logo-seit-SinFondo-Oscuro.png') }}" alt="SEIT GDL, Soluciones en Tecnología" class="h-[62px] w-auto object-contain sm:h-[64px]">
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
                            {{ mb_strtoupper(mb_substr(auth()->user()->nombre ?? 'S', 0, 1) . mb_substr(auth()->user()->apellido ?? '', 0, 1)) }}
                        </span>
                        <span class="text-sm font-medium text-white">
                            {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                        </span>
                    </div>
                </header>

                @isset($header)
                    <div class="seit-page-header px-6 py-5 sm:px-8">
                        {{ $header }}
                    </div>
                @endisset

                <main class="seit-main flex-1 p-6 sm:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
