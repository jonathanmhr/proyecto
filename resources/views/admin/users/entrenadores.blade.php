<x-app-layout>
    <x-slot name="header">
        {{-- Título del slot header - Cambiado a texto blanco --}}
        <h2 class="font-semibold text-xl text-white leading-tight">Entrenadores y Admin Entrenador</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <div class="flex justify-between items-center mb-4">
            {{-- Formulario de búsqueda - Elementos oscuros con texto claro --}}
            <form method="GET" action="{{ route('admin.entrenadores') }}" class="flex space-x-2">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Buscar por nombre o email"
                    class="bg-gray-700 border-gray-600 text-white rounded px-3 py-1 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500" {{-- Input oscuro, borde, texto blanco, placeholder gris, focus azul --}}
                />
                {{-- Botón Buscar - Mismo azul consistente --}}
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow">Buscar</button>
            </form>

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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th> {{-- Texto más claro --}}
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Roles</th> {{-- Texto más claro --}}
                        <th class="px-6 py-3"></th> {{-- Sin texto, se aplica el estilo por defecto del th --}}
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700"> {{-- Fondo de cuerpo más oscuro, divisor más oscuro --}}
                    @forelse ($entrenadores as $user) {{-- Usamos @forelse para el caso de no resultados --}}
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-white">{{ $user->name }}</td> {{-- Texto blanco --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $user->email }}</td> {{-- Texto gris claro --}}
                        <td class="px-6 py-4 whitespace-nowrap text-gray-300"> {{-- Texto gris claro para los roles --}}
                            {{ $user->roles->pluck('name')->map(fn($role) => ucfirst($role))->join(', ') }} {{-- Aseguramos que los nombres de los roles estén en mayúscula la primera letra --}}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            {{-- Formulario para asignar rol --}}
                            <form method="POST" action="{{ route('admin.users.assignRole', $user->id) }}" class="inline">
                                @csrf
                                {{-- Select oscuro con borde y foco acorde --}}
                                <select name="role" class="bg-gray-700 border-gray-600 text-white rounded px-2 py-1 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="cliente" class="bg-gray-700 text-white">Cliente</option>
                                    <option value="entrenador" class="bg-gray-700 text-white">Entrenador</option>
                                    <option value="admin_entrenador" class="bg-gray-700 text-white">Admin Entrenador</option>
                                    <option value="admin" class="bg-gray-700 text-white">Admin</option>
                                </select>
                                {{-- Botón Cambiar Rol - Verde oscuro para acciones positivas --}}
                                <button type="submit" class="ml-2 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 shadow">Cambiar Rol</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                No se encontraron entrenadores o admin-entrenadores con esos criterios.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación - Texto blanco si no se estiliza automáticamente por Tailwind --}}
        <div class="mt-4 text-white">
            {{ $entrenadores->links() }}
        </div>
    </div>
</x-app-layout>