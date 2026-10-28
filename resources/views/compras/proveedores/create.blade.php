<x-app-layout>
    <x-slot name="header">
        <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#00A8FF]">Compras SEIT</p>
            <h1 class="mt-1 text-2xl font-semibold text-white">Registrar proveedor</h1>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl">
        @include('compras.proveedores._form', ['proveedor' => null])
    </div>
</x-app-layout>
