<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4">
        @if (session('success'))
            <x-alert type="success" title="¡Éxito!" message="{{ session('success') }}" />
        @endif

        @if (session('error'))
            <x-alert type="error" title="Error" message="{{ session('error') }}" />
        @endif

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Panel de Usuarios</h1>
            <a href="{{ route('admin.usuarios.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                <x-icon-plus class="w-5 h-5" />
                Nuevo Usuario
            </a>
        </div>

        <!-- Filtros -->
        <form method="GET" action="{{ route('admin.usuarios.index') }}"
              class="bg-white p-4 mb-6 rounded-lg shadow flex flex-col sm:flex-row sm:items-end gap-4">
            <div class="flex-1">
                <label for="search" class="text-sm font-medium text-gray-700">Buscar</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}"
                       placeholder="Nombre o email"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="sm:w-48">
                <label for="role" class="text-sm font-medium text-gray-700">Rol</label>
                <select id="role" name="role"
                        class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">-- Todos --</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="entrenador" {{ request('role') == 'entrenador' ? 'selected' : '' }}>Entrenador</option>
                    <option value="cliente" {{ request('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin_entrenador" {{ request('role') == 'admin_entrenador' ? 'selected' : '' }}>Admin Entrenador</option>
                </select>
            </div>
            <div>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-md transition">
                    <x-icon-search class="w-4 h-4" />
                    Filtrar
                </button>
            </div>
        </form>

        <!-- Tabla -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Roles</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-gray-900 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach ($user->roles as $role)
                                    <span class="inline-block px-2 py-0.5 text-xs font-medium rounded-full
                                        {{ match($role->name) {
                                            'admin' => 'bg-red-100 text-red-800',
                                            'entrenador' => 'bg-green-100 text-green-800',
                                            'cliente' => 'bg-blue-100 text-blue-800',
                                            'admin_entrenador' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-gray-100 text-gray-800',
                                        } }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-1">
                                <!-- Editar -->
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="inline-flex items-center p-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                                   title="Editar usuario">
                                    <x-icon-edit class="w-4 h-4" />
                                </a>

                                <!-- Resetear contraseña -->
                                <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center p-2 bg-purple-600 hover:bg-purple-700 text-white rounded-md"
                                            title="Resetear contraseña">
                                        <x-icon-refresh class="w-4 h-4" />
                                    </button>
                                </form>

                                <!-- Cambiar estado -->
                                <form action="{{ route('admin.users.changeStatus', $user->id) }}" method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center p-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md"
                                            title="Cambiar estado">
                                        <x-icon-toggle class="w-4 h-4" />
                                    </button>
                                </form>

                                <!-- Eliminar -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center p-2 bg-red-600 hover:bg-red-700 text-white rounded-md"
                                            title="Eliminar usuario">
                                        <x-icon-trash class="w-4 h-4" />
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
