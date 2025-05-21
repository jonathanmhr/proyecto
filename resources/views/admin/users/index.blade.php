<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- Flash Messages --}}
        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
            @if (session($type))
                <div class="p-4 rounded-lg bg-{{ $color }}-50 border border-{{ $color }}-300 text-{{ $color }}-800 shadow-sm">
                    <h2 class="font-semibold text-lg mb-1">{{ $type === 'success' ? '¡Éxito!' : 'Error' }}</h2>
                    <p>{{ session($type) }}</p>
                </div>
            @endif
        @endforeach

        {{-- Título --}}
        <h1 class="text-3xl font-bold text-gray-800">Usuarios</h1>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('admin.usuarios.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md text-sm font-medium transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Usuario
            </a>

            <a href="{{ route('dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium transition-colors">
                ← Volver al Dashboard
            </a>
        </div>

        {{-- Filtros --}}
        <div class="bg-white p-6 rounded-lg shadow-md w-full">
            <form method="GET" action="{{ route('admin.usuarios.index') }}"
                  class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 w-full">
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700">Buscar por nombre o email</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}"
                           class="mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ej: usuario@example.com">
                </div>

                <div class="flex flex-col md:flex-row md:items-end gap-2">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select name="role" id="role"
                                class="mt-1 w-full md:w-40 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Todos --</option>
                            @foreach(['admin', 'entrenador', 'cliente', 'admin_entrenador'] as $role)
                                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}>
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 mt-1 md:mt-6">
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
                            🔍 Filtrar
                        </button>
                        <a href="{{ route('admin.usuarios.index') }}"
                           class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md text-sm font-medium transition-colors">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tabla de Usuarios --}}
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4 space-x-1">
                                @foreach ($user->roles as $role)
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ match ($role->name) {
                                            'admin' => 'bg-red-200 text-red-800',
                                            'entrenador' => 'bg-green-200 text-green-800',
                                            'cliente' => 'bg-blue-200 text-blue-800',
                                            'admin_entrenador' => 'bg-purple-200 text-purple-800',
                                            default => 'bg-gray-200 text-gray-800',
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
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                   class="inline-flex items-center px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                                   title="Editar usuario">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md"
                                            title="Resetear contraseña">
                                        <i data-feather="refresh-ccw"></i>
                                    </button>
                                </form>
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
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline"
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

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $users->links() }}
        </div>

        {{-- Modal --}}
        <div id="confirm-modal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 flex items-center justify-center">
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

        {{-- Script modal --}}
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

            document.getElementById('confirm-button').addEventListener('click', () => {
                if (formToSubmit) formToSubmit.submit();
            });

            document.addEventListener('DOMContentLoaded', () => {
                if (typeof feather !== 'undefined') feather.replace();
            });
        </script>
    </div>
</x-app-layout>