<x-app-layout>
    <x-slot name="header">
        {{-- Título del slot header - Cambiado a texto blanco --}}
        <h2 class="font-semibold text-xl text-white leading-tight">Roles</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-4">
            {{-- Botón Crear Rol - Usamos el azul consistente --}}
            <a href="{{ route('admin.roles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow">
                Crear Rol
            </a>
            {{-- Botón Volver al dashboard - Mismo azul consistente --}}
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                ← Volver al dashboard
            </a>
        </div>

        {{-- Contenedor de la Tabla - Fondo oscuro y borde --}}
        <div class="bg-gray-800 shadow rounded-lg overflow-hidden border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700"> {{-- Divisor más oscuro --}}
                <thead class="bg-gray-700"> {{-- Fondo de cabecera más oscuro --}}
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nombre</th> {{-- Texto más claro --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Título</th> {{-- Texto más claro --}}
                        <th class="px-6 py-3"></th> {{-- Sin texto, se aplica el estilo por defecto del th --}}
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700"> {{-- Fondo de cuerpo más oscuro, divisor más oscuro --}}
                    @forelse ($roles as $role) {{-- Usamos @forelse para el caso de no resultados --}}
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $role->name }}</td> {{-- Texto blanco --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $role->title }}</td> {{-- Texto gris claro --}}
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            {{-- Enlaces de acción - Adaptados a la paleta --}}
                            <a href="{{ route('admin.roles.edit', $role->id) }}" class="text-blue-400 hover:text-blue-300 transition-colors">Editar</a> {{-- Azul más claro para enlaces en modo oscuro --}}

                            <form action="{{ route('admin.roles.destroy', $role->id) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar rol {{ $role->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-400 hover:text-red-300 transition-colors">Eliminar</button> {{-- Rojo más claro para acciones destructivas --}}
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-400">
                                No se encontraron roles.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($roles, 'links'))
            <div class="mt-6 text-white"> {{-- Texto blanco para la paginación --}}
                {{ $roles->links() }}
            </div>
        @endif

    </div>
</x-app-layout>