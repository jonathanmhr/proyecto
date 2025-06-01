<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6 space-y-6">

        {{-- Flash Messages --}}
        @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
            @if (session($type))
                <div
                    class="p-4 rounded-lg bg-{{ $color }}-800 border border-{{ $color }}-600 text-{{ $color }}-200 shadow-md">
                    <h2 class="font-semibold text-lg mb-1">{{ $type === 'success' ? '¡Éxito!' : 'Error' }}</h2>
                    <p>{{ session($type) }}</p>
                </div>
            @endif
        @endforeach

        {{-- Título --}}
        <h1 class="text-3xl font-bold text-white">Usuarios</h1>

        {{-- Botones --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <a href="{{ route('admin.usuarios.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Usuario
            </a>

            <a href="{{ route('admin.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow transition">
                ← Volver al dashboard
            </a>
        </div>

        {{-- Filtros --}}
        <div class="bg-gray-800 p-6 rounded-lg shadow-md w-full border border-gray-700">
            <form method="GET" action="{{ route('admin.usuarios.index') }}" id="searchForm"
                class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 w-full">
                <div class="flex-1">
                    <label for="searchInput" class="block text-sm font-medium text-gray-300">Buscar por nombre o
                        email</label>
                    <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                        class="mt-1 w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"
                        placeholder="Ej: usuario@example.com">
                    <p id="searchError" class="text-red-500 text-sm mt-1 hidden"></p>
                </div>

                <div class="flex flex-col md:flex-row md:items-end gap-4">
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-300">Rol</label>
                        <select name="role" id="role"
                            class="mt-1 w-full md:w-40 bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="" class="bg-gray-700 text-white">-- Todos --</option>
                            @foreach (['admin', 'entrenador', 'cliente', 'admin_entrenador'] as $role)
                                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}
                                    class="bg-gray-700 text-white">
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-2 mt-1 md:mt-6">
                        <button type="submit" id="searchButton"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors shadow">
                            🔍 Filtrar
                        </button>
                        <a href="{{ route('admin.usuarios.index') }}"
                            class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md text-sm font-medium transition-colors shadow">
                            Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </div>


        {{-- Tabla de Usuarios --}}
        {{-- Fondo oscuro para la tabla --}}
        <div class="bg-gray-800 rounded-xl shadow overflow-x-auto border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700"> {{-- Divisor más oscuro --}}
                <thead class="bg-gray-700 text-xs font-semibold text-gray-300 uppercase"> {{-- Fondo de cabecera más oscuro, texto más claro --}}
                    <tr>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                {{-- Filas de la tabla --}}
                <tbody class="bg-gray-800 divide-y divide-gray-700 text-sm"> {{-- Fondo de cuerpo más oscuro, divisor más oscuro --}}
                    @foreach ($users as $user)
                        <tr>
                            {{-- Texto de celdas --}}
                            <td class="px-6 py-4 font-medium text-white">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-300">{{ $user->email }}</td>
                            <td class="px-6 py-4 space-x-1">
                                @foreach ($user->roles as $role)
                                    <span
                                        class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ match ($role->name) {
                                            'admin' => 'bg-red-700 text-red-100', // Rojo oscuro para admin
                                            'entrenador' => 'bg-green-700 text-green-100', // Verde oscuro para entrenador
                                            'cliente' => 'bg-blue-700 text-blue-100', // Azul oscuro para cliente
                                            'admin_entrenador' => 'bg-purple-700 text-purple-100', // Morado oscuro
                                            default => 'bg-gray-600 text-gray-100',
                                        } }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                                {{-- Esta condición para $users->isEmpty() está fuera de lugar aquí, debería ir después del foreach --}}
                                {{-- Se elimina aquí para evitar un error de lógica --}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->is_active ? 'bg-green-700 text-green-100' : 'bg-red-700 text-red-100' }}">
                                    {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-1">
                                {{-- Botones de acción - Adaptados a la paleta --}}
                                <a href="{{ route('admin.users.edit', $user->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-600 hover:bg-yellow-700 text-white rounded-md shadow"
                                    title="Editar usuario">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="event.preventDefault(); confirmAction('¿Deseas resetear la contraseña de este usuario?', this);">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md shadow"
                                        title="Resetear contraseña">
                                        <i data-feather="refresh-ccw"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.changeStatus', $user->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="event.preventDefault(); confirmAction('¿Deseas cambiar el estado de este usuario?', this);">
                                    @csrf
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md shadow"
                                        title="Cambiar estado">
                                        <i data-feather="toggle-left"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    class="inline"
                                    onsubmit="event.preventDefault(); confirmAction('¿Estás seguro de eliminar este usuario?', this);">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md shadow"
                                        title="Eliminar usuario">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    {{-- Esta es la ubicación correcta para la condición isEmpty --}}
                    @if ($users->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-400">
                                No se encontraron usuarios con esos criterios.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        {{-- Laravel Blade Paginator debería adoptar automáticamente el estilo de Tailwind si está configurado --}}
        <div class="mt-4 text-white"> {{-- Agregado text-white para la paginación si no se estiliza automáticamente --}}
            {{ $users->links() }}
        </div>

        {{-- Modal --}}
        {{-- Fondo del modal y texto adaptados --}}
        <div id="confirm-modal"
            class="fixed inset-0 z-50 hidden bg-black bg-opacity-70 flex items-center justify-center">
            {{-- Opacidad más alta para el fondo --}}
            <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-sm w-full border border-gray-700">
                {{-- Fondo oscuro, borde sutil --}}
                <h2 class="text-lg font-bold mb-4 text-white">Confirmar acción</h2> {{-- Texto blanco --}}
                <p class="text-gray-300 mb-6" id="confirm-message">¿Estás seguro?</p> {{-- Texto más claro --}}
                <div class="flex justify-end gap-2">
                    {{-- Botón Cancelar - Fondo gris oscuro --}}
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md shadow">Cancelar</button>
                    {{-- Botón Confirmar - Rojo oscuro (para acciones destructivas) --}}
                    <button id="confirm-button"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md shadow">Confirmar</button>
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
    @push('scripts')
        @vite('resources/js/scripts/busqueda.js')
    @endpush
</x-app-layout>
