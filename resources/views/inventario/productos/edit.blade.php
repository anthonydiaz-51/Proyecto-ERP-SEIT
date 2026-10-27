<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div><p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Inventario SEIT</p><h1 class="mt-1 text-2xl font-semibold text-white">Editar producto</h1></div>
            <a href="{{ route('inventario.index') }}" class="text-sm font-semibold text-[#a7b4c1] hover:text-white">← Volver al inventario</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">
        @include('inventario.productos._form', ['producto' => $producto, 'categorias' => $categorias])
    </div>
</x-app-layout>
