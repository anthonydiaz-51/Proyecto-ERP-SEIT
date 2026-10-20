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
        <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <div
                x-show="sidebarOpen"
                x-cloak
                x-transition.opacity
                @click="sidebarOpen = false"
                class="fixed inset-0 z-30 bg-black/30"
                aria-hidden="true"
            ></div>
            <x-sidebar />

            <div class="flex-1 flex flex-col">
                {{-- Top bar delgado: solo usuario --}}
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-3 flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('dashboard') }}" class="text-lg font-bold text-gray-900 hover:text-red-700 focus:outline-none focus:ring-2 focus:ring-red-600 dark:text-gray-100 dark:hover:text-red-400" aria-label="Ir a la página principal de SEIT">SEIT</a>
                        <button
                            type="button"
                            @click="sidebarOpen = !sidebarOpen"
                            :aria-label="sidebarOpen ? 'Cerrar menú' : 'Abrir menú'"
                            :aria-expanded="sidebarOpen"
                            aria-controls="app-sidebar"
                            title="Menú"
                            class="inline-flex h-9 w-9 items-center justify-center rounded-md text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:text-gray-300 dark:hover:bg-gray-700"
                        >
                            <span class="sr-only">Menú</span>
                            <span class="flex w-5 flex-col gap-1" aria-hidden="true">
                                <span class="h-0.5 w-full bg-current"></span>
                                <span class="h-0.5 w-full bg-current"></span>
                                <span class="h-0.5 w-full bg-current"></span>
                            </span>
                        </button>
                    </div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">
                        {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}
                    </span>
                </header>

                @isset($header)
                    <div class="bg-white dark:bg-gray-800 shadow-sm px-6 py-4">
                        {{ $header }}
                    </div>
                @endisset

                <main class="flex-1 p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>