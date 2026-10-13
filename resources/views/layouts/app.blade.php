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
        <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900">
            <x-sidebar />

            <div class="flex-1 flex flex-col">
                {{-- Top bar delgado: solo usuario --}}
                <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 px-6 py-3 flex justify-end">
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