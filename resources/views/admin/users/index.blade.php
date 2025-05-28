<x-app-layout>
    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-300 text-green-800 shadow-sm">
            <h2 class="font-semibold text-lg mb-1">¡Éxito!</h2>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-300 text-red-800 shadow-sm">
            <h2 class="font-semibold text-lg mb-1">Error</h2>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <h1 class="text-3xl font-bold mb-6">Panel de usuarios</h1>

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

<<<<<<< Updated upstream
        <!-- Filtros -->
        <form method="GET" action="{{ route('admin.usuarios.index') }}"
            class="mb-4 bg-gray-800 p-4 rounded-lg shadow flex flex-wrap items-center gap-4">
            <div class="w-full sm:w-auto flex-1">
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nombre o email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
=======
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Buscador -->
        <form method="GET" action="{{ route('admin.users.index') }}"
            class="bg-gray-800 shadow-md rounded-lg mb-6 p-4 flex flex-col md:flex-row md:justify-between items-center gap-4">

            <div class="relative w-full md:w-1/2">
                <input type="text" name="search" id="search" placeholder="Buscar por nombre o email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}">
                <p id="error-message" class="text-red-500 text-sm mt-1 hidden">
                    Por favor, ingresa entre 3 y 100 caracteres para la búsqueda.
                </p>
>>>>>>> Stashed changes
            </div>

            <div class="flex items-center gap-2">
                <label for="role" class="text-sm font-medium text-gray-100">Filtrar por rol:</label>
                <select name="role" id="role"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm"
                    onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="admin_entrenador" {{ request('role') == 'admin_entrenador' ? 'selected' : '' }}>Admin
                        Entrenador</option>
                    <option value="entrenador" {{ request('role') == 'entrenador' ? 'selected' : '' }}>Entrenador
                    </option>
                    <option value="cliente" {{ request('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin_entrenador" {{ request('role') == 'admin_entrenador' ? 'selected' : '' }}>Admin
                        Entrenador</option>
                </select>
            </div>

<<<<<<< Updated upstream
            <div class="self-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-gray-700 text-white rounded-md text-sm font-medium transition-all duration-300-colors">
                    🔍 Filtrar
                </button>
            </div>
=======
            <button type="submit" class="bg-red-500 hover:bg-gray-600 text-white px-5 py-2 rounded-md transition-all duration-300">
                Buscar
            </button>
>>>>>>> Stashed changes
        </form>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-red-500 text-white text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Roles</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-800 divide-y divide-gray-700">
                    @foreach ($users as $user)
<<<<<<< Updated upstream
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach ($user->roles as $role)
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $role->name === 'admin' ? 'bg-red-200 text-red-800' : '' }}
                                        {{ $role->name === 'entrenador' ? 'bg-green-200 text-green-800' : '' }}
                                        {{ $role->name === 'cliente' ? 'bg-blue-200 text-blue-800' : '' }}
                                        {{ $role->name === 'admin_entrenador' ? 'bg-purple-200 text-purple-800' : '' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
=======
                        <tr class="hover:bg-gray-600 transition">
                            <td class="px-6 py-5 text-sm font-medium text-gray-100">{{ $user->id }}</td>
                            <td class="px-6 py-5 text-sm text-gray-100">{{ $user->name }}</td>
                            <td class="px-6 py-5 text-sm text-gray-100">{{ $user->email }}</td>
                            <td class="px-6 py-5 text-sm text-gray-100">{{ $user->created_at->format('d/m/Y H:i') }}
>>>>>>> Stashed changes
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if ($user->is_active)
                                    <span
                                        class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                @else
                                    <span
                                        class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>
                                @endif
                            </td>
<<<<<<< Updated upstream
                            <td class="px-6 py-4 text-center space-x-1">
                                <!-- Editar -->
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                                    title="Editar usuario">
                                    <i data-feather="edit"></i>
                                </a>
=======
                            <td class="px-6 py-5 text-sm text-gray-100">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-2">
                                    <!-- Asignar rol -->
                                    <form method="POST" action="{{ route('admin.users.assignRole', $user->id) }}"
                                        class="flex gap-2 items-center">
                                        @csrf
                                        <select name="role"
                                            class="border border-gray-300 rounded-md px-3 py-2 text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="admin">Administrador</option>
                                            <option value="admin_entrenador">Admin Entrenador</option>
                                            <option value="entrenador">Entrenador</option>
                                            <option value="cliente">Cliente</option>
                                        </select>
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-md flex items-center gap-1 transition-transform transform hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v16m8-8H4" />
                                            </svg>
                                            Asignar
                                        </button>
                                    </form>
>>>>>>> Stashed changes

                                <!-- Resetear contraseña -->
                                <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md"
                                        title="Resetear contraseña">
                                        <i data-feather="refresh-ccw"></i>
                                    </button>
                                </form>

                                <!-- Cambiar estado -->
                                <form action="{{ route('admin.users.changeStatus', $user->id) }}" method="POST"
                                    class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md"
                                        title="Cambiar estado">
                                        <i data-feather="toggle-left"></i>
                                    </button>
                                </form>

                                <!-- Eliminar -->
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md"
                                        title="Eliminar usuario">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <!-- Paginación -->
            <div class="py-6 bg-gray-700">
                <div class="flex justify-center bg-gray-700">
                    {{ $users->links() }}
                </div>

                
        </div>
    </div>
</x-app-layout>
