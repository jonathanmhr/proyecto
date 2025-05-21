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

    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-800">Gestión de usuarios</h1>
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md shadow-sm transition-colors">
            <i data-feather="arrow-left" class="mr-2"></i>
            Volver al Dashboard
        </a>
    </div>


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
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    placeholder="Nombre o email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                <select name="role" id="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    <option value="">-- Todos --</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="entrenador" {{ request('role') == 'entrenador' ? 'selected' : '' }}>Entrenador
                    </option>
                    <option value="cliente" {{ request('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                    <option value="admin_entrenador" {{ request('role') == 'admin_entrenador' ? 'selected' : '' }}>Admin
                        Entrenador</option>
                </select>
            </div>

            <div class="self-end">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                    🔍 Filtrar
                </button>
            </div>
        </form>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <!-- Modal de Confirmación -->
            <div id="confirm-modal"
                class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
                <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
                    <h2 class="text-lg font-bold mb-4 text-gray-800">Confirmar acción</h2>
                    <p class="text-gray-600 mb-6" id="confirm-message">¿Estás seguro?</p>
                    <div class="flex justify-end gap-2">
                        <button onclick="closeModal()"
                            class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md">Cancelar</button>
                        <button id="confirm-button"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md">Confirmar</button>
                    </div>
                </div>
            </div>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Roles</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
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
                            <td class="px-6 py-4 text-center space-x-1">
                                <!-- Editar -->
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                                    title="Editar usuario">
                                    <i data-feather="edit"></i>
                                </a>

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
                                    class="inline"
                                    onsubmit="event.preventDefault(); confirmAction('¿Deseas cambiar el estado de este usuario?', this);">
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
                                    onsubmit="event.preventDefault(); confirmAction('¿Estás seguro de eliminar este usuario?', this);">
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
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
    <script>
        let formToSubmit = null;

        function confirmAction(message, form) {
            document.getElementById('confirm-message').innerText = message;
            document.getElementById('confirm-modal').classList.remove('hidden');
            formToSubmit = form;
        }

        function closeModal() {
            document.getElementById('confirm-modal').classList.add('hidden');
            formToSubmit = null;
        }

        document.getElementById('confirm-button').addEventListener('click', function() {
            if (formToSubmit) formToSubmit.submit();
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') feather.replace();
        });
    </script>
</x-app-layout>
