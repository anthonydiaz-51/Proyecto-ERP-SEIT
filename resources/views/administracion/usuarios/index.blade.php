<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white">Usuarios</h2>
            <a href="{{ route('administracion.usuarios.create') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                + Nuevo usuario
            </a>
        </div>
    </x-slot>

    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-4">
            <div class="bg-green-50 text-green-700 px-4 py-3 rounded-md text-sm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto mt-4">
            <div class="bg-red-50 text-red-700 px-4 py-3 rounded-md text-sm">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto py-6">
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rol</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Activo</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                        $roles = [1 => 'Administrador', 2 => 'Gerencia', 3 => 'Ventas', 4 => 'Técnico', 5 => 'Practicante'];
                    @endphp
                    @forelse ($usuarios as $usuario)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $usuario->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $roles[$usuario->rol_id] ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($usuario->activo)
                                    <span class="text-green-600">Sí</span>
                                @else
                                    <span class="text-red-500">No</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right text-sm">
                                <a href="{{ route('administracion.usuarios.edit', $usuario) }}" class="text-indigo-600 hover:underline">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                                Aún no hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $usuarios->links() }}
        </div>
    </div>
</x-app-layout>