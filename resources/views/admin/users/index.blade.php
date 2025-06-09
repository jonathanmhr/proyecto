<x-app-layout>
    {{-- Header Slot (puede ser vacío o para elementos globales de la app-layout) --}}
    <x-slot name="header"></x-slot>

    {{-- Sección de Encabezado y Acciones Principales --}}
    <div class="bg-gray-900 shadow-md py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row justify-between items-center max-w-7xl mx-auto">
            <h1 class="text-3xl font-extrabold leading-tight text-white mb-4 sm:mb-0">
                Gestión de Usuarios
            </h1>
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('admin.usuarios.create') }}"
                    class="inline-flex items-center px-5 py-2 bg-blue-700 text-white font-semibold rounded-full shadow-lg hover:bg-blue-800 transition duration-300 ease-in-out transform hover:scale-105">
                    <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i>
                    Nuevo Usuario
                </a>
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center px-5 py-2 bg-gray-700 text-white font-semibold rounded-full shadow-lg hover:bg-gray-600 transition duration-300 ease-in-out transform hover:scale-105">
                    <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i>
                    Volver al Dashboard
                </a>
            </div>
        </div>
    </div>

    {{-- Contenedor principal de la vista --}}
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8"> {{-- Más espaciado y padding consistente --}}

            {{-- Flash Messages --}}
            @foreach (['success' => 'green', 'error' => 'red'] as $type => $color)
                @if (session($type))
                    <div
                        class="p-4 rounded-lg bg-{{ $color }}-800 border border-{{ $color }}-600 text-{{ $color }}-200 shadow-md transition-opacity duration-300 ease-out opacity-100"
                        x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0">
                        <h2 class="font-semibold text-xl mb-1">{{ $type === 'success' ? '¡Éxito!' : 'Error' }}</h2>
                        <p class="text-base">{{ session($type) }}</p>
                    </div>
                @endif
            @endforeach

            {{-- Sección de Filtros --}}
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
                <form method="GET" action="{{ route('admin.usuarios.index') }}" id="searchForm"
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 items-end">
                    <div class="col-span-1 md:col-span-2 lg:col-span-2">
                        <label for="searchInput" class="block text-sm font-medium text-gray-300 mb-1">Buscar por nombre o
                            email</label>
                        <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                            class="w-full p-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 placeholder-gray-400 transition duration-200"
                            placeholder="Ej: nombre.apellido o usuario@email.com">
                        <p id="searchError" class="text-red-500 text-sm mt-1 hidden"></p>
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-300 mb-1">Filtrar por Rol</label>
                        <select name="role" id="role"
                            class="w-full p-3 bg-gray-700 border border-gray-600 text-white rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                            <option value="" class="bg-gray-700 text-gray-300">Filtrar por Roles</option>
                            @foreach (['admin', 'entrenador', 'cliente', 'admin_entrenador'] as $role)
                                <option value="{{ $role }}" {{ request('role') === $role ? 'selected' : '' }}
                                    class="bg-gray-700 text-white">
                                    {{ ucfirst($role) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex gap-4 col-span-1 md:col-span-3 lg:col-span-1 justify-end">
                        <button type="submit" id="searchButton"
                            class="flex-1 sm:flex-none px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-base font-semibold transition duration-300 ease-in-out transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
                            <i data-feather="search" class="w-5 h-5 mr-2 inline-block"></i> Filtrar
                        </button>
                        <a href="{{ route('admin.usuarios.index') }}"
                            class="flex-1 sm:flex-none px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-base font-semibold transition duration-300 ease-in-out transform hover:scale-105 shadow-md focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75">
                            <i data-feather="x-circle" class="w-5 h-5 mr-2 inline-block"></i> Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- Tabla de Usuarios --}}
            <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden border border-gray-700"> {{-- Overflow hidden para bordes redondeados consistentes --}}
                <div class="overflow-x-auto"> {{-- Permite scroll horizontal en pantallas pequeñas --}}
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    Nombre
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    Roles
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-800 divide-y divide-gray-700">
                            @forelse ($users as $user)
                                <tr class="hover:bg-gray-750"> {{-- Ligero hover para filas --}}
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="text-sm font-medium text-white">{{ $user->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-300">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-wrap gap-1"> {{-- Para que los roles no se desborden --}}
                                            @foreach ($user->roles as $role)
                                                <span
                                                    class="px-2 py-0.5 rounded-full text-xs font-medium
                                                    {{ match ($role->name) {
                                                        'admin' => 'bg-red-700 text-red-100',
                                                        'entrenador' => 'bg-green-700 text-green-100',
                                                        'cliente' => 'bg-blue-700 text-blue-100',
                                                        'admin_entrenador' => 'bg-purple-700 text-purple-100',
                                                        default => 'bg-gray-600 text-gray-100',
                                                    } }}">
                                                    {{ ucfirst($role->name) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-600 text-green-100' : 'bg-red-600 text-red-100' }}">
                                            {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="text-yellow-400 hover:text-yellow-300 transition duration-150 ease-in-out"
                                                title="Editar usuario">
                                                <i data-feather="edit" class="w-5 h-5"></i>
                                            </a>
                                            <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="event.preventDefault(); confirmAction('¿Estás seguro de que deseas resetear la contraseña de {{ $user->name }}?', this);">
                                                @csrf
                                                <button type="submit"
                                                    class="text-purple-400 hover:text-purple-300 transition duration-150 ease-in-out"
                                                    title="Resetear contraseña">
                                                    <i data-feather="refresh-ccw" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.changeStatus', $user->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="event.preventDefault(); confirmAction('¿Deseas {{ $user->is_active ? 'desactivar' : 'activar' }} a {{ $user->name }}?', this);">
                                                @csrf
                                                <button type="submit"
                                                    class="text-gray-400 hover:text-gray-300 transition duration-150 ease-in-out"
                                                    title="{{ $user->is_active ? 'Desactivar usuario' : 'Activar usuario' }}">
                                                    <i data-feather="{{ $user->is_active ? 'toggle-right' : 'toggle-left' }}" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="event.preventDefault(); confirmAction('¿Estás seguro de eliminar a {{ $user->name }} de forma permanente?', this);">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-400 hover:text-red-300 transition duration-150 ease-in-out"
                                                    title="Eliminar usuario">
                                                    <i data-feather="trash-2" class="w-5 h-5"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-6 text-gray-400 text-lg">
                                        No se encontraron usuarios con esos criterios.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4 text-white"> {{-- Agregado text-white para la paginación si no se estiliza automáticamente --}}
                {{ $users->links() }}
            </div>

        </div>
    </div>

    {{-- Modal de Confirmación Global --}}
    <div id="confirm-modal"
        class="fixed inset-0 z-50 hidden bg-black bg-opacity-70 flex items-center justify-center p-4">
        <div class="bg-gray-800 p-6 rounded-lg shadow-xl max-w-sm w-full border border-gray-700 animate-fade-in-up">
            <h2 class="text-2xl font-bold mb-4 text-white">Confirmar Acción</h2>
            <p class="text-gray-300 mb-6 text-base" id="confirm-message">¿Estás seguro de realizar esta acción?</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeModal()"
                    class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg shadow-md transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75">Cancelar</button>
                <button id="confirm-button"
                    class="px-6 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">Confirmar</button>
            </div>
        </div>
    </div>

    @push('scripts')
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
                if (formToSubmit) {
                    formToSubmit.submit();
                }
            });

            // Opcional: Cerrar modal si se hace clic fuera de él
            document.getElementById('confirm-modal').addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });

            // Validación básica para el campo de búsqueda (client-side)
            document.addEventListener('DOMContentLoaded', () => {
                const searchInput = document.getElementById('searchInput');
                const searchButton = document.getElementById('searchButton');
                const searchError = document.getElementById('searchError');
                const searchForm = document.getElementById('searchForm');

                searchForm.addEventListener('submit', function(event) {
                    if (searchInput.value.length > 0 && searchInput.value.length < 3) {
                        event.preventDefault();
                        searchError.innerText = 'Ingresa al menos 3 caracteres para buscar.';
                        searchError.classList.remove('hidden');
                        searchInput.classList.add('border-red-500', 'focus:border-red-500');
                    } else {
                        searchError.classList.add('hidden');
                        searchInput.classList.remove('border-red-500', 'focus:border-red-500');
                    }
                });

                if (typeof feather !== 'undefined') {
                    feather.replace();
                }
            });
        </script>
        {{-- Asegúrate de que este Vite alias esté configurado correctamente en vite.config.js --}}
        @vite('resources/js/scripts/busqueda.js')
    @endpush
</x-app-layout>