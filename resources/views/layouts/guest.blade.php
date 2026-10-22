<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-gray-100 px-4 py-10 sm:bg-gray-900">
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <div class="absolute -left-32 top-0 h-96 w-96 rounded-full bg-[#00A8FF]/10 blur-3xl"></div>
                <div class="absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-[#FF2B2B]/10 blur-3xl"></div>
            </div>

            <div class="relative z-10 mb-7 text-center">
                <a href="{{ route('dashboard') }}" class="inline-flex flex-col items-center" aria-label="Ir al inicio de SEIT">
                    <span class="seit-brand-mark text-4xl sm:text-5xl" aria-hidden="true">
                        <span>SEIT</span><span class="brand-red">GDL</span>
                    </span>
                    <span class="mt-2 text-[10px] font-semibold uppercase tracking-[0.24em] text-gray-400">
                        Soluciones en Tecnología
                    </span>
                </a>
            </div>

            <div class="relative z-10 w-full overflow-hidden rounded-2xl border border-[#00A8FF]/20 bg-white px-6 py-7 shadow-2xl sm:max-w-md sm:px-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
