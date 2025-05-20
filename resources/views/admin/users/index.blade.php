<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <div class="mb-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-700">Usuarios</h3>
            <a href="{{ route('admin.usuarios.create') }}"
                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Usuario
            </a>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('admin.usuarios.index') }}"
            class="mb-4 bg-white p-4 rounded-lg shadow flex flex-wrap items-center gap-4">
            <div class="w-full sm:w-auto flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar por nombre o correo</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Ej. Juan o juan@email.com"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Todos --</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="entrenador" {{ request('role') == 'entrenador' ? 'selected' : '' }}>Entrenador</option>
                    <option value="cliente" {{ request('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin_entrenador" {{ request('role') == 'admin_entrenador' ? 'selected' : '' }}>Admin Entrenador</option>
                </select>
            </div>

            <div class="self-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
                    </svg>
                    Filtrar
                </button>
            </div>
        </form>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Roles</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 text-sm">
                                @foreach ($user->roles as $role)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $role->name === 'admin' ? 'bg-red-200 text-red-800' : '' }}
                                        {{ $role->name === 'entrenador' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $role->name === 'cliente' ? 'bg-blue-200 text-blue-800' : '' }}
                                        {{ $role->name === 'admin_entrenador' ? 'bg-purple-200 text-purple-800' : '' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($user->is_active)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-1">
                                <!-- Editar -->
                                <a href="{{ route('admin.usuarios.edit', $user) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                                    title="Editar usuario">
                                    ✏️
                                </a>

                                <!-- Resetear contraseña -->
                                <form action="{{ route('admin.usuarios.reset', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-xs font-semibold transition-colors duration-200"
                                        title="Resetear contraseña">
                                        🔄
                                    </button>
                                </form>

                                <!-- Cambiar estado -->
                                <form action="{{ route('admin.usuarios.estado', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md text-xs font-semibold transition-colors duration-200"
                                        title="Cambiar estado">
                                        ⚙️
                                    </button>
                                </form>

                                <!-- Eliminar -->
                                <form action="{{ route('admin.usuarios.destroy', $user) }}" method="POST" class="inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition-colors duration-200"
                                        title="Eliminar usuario">
                                        🗑️
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
