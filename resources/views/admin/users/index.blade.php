<x-app-layout>
    <div x-data="{ isOpen: false, modalType: '', selectedUserId: null }">

        <!-- Buscador y filtros -->
        <form method="GET" action="{{ route('admin.users.index') }}"
            class="bg-white shadow-md rounded-lg mb-6 p-4 flex flex-col md:flex-row md:justify-between items-center gap-4">

            <div class="relative w-full md:w-1/2">
                <input type="text" name="search" id="search" placeholder="Buscar por nombre o email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}">
                <p id="error-message" class="text-red-500 text-sm mt-1 hidden">
                    Por favor, ingresa entre 3 y 100 caracteres para la búsqueda.
                </p>
            </div>

            <div class="w-full md:w-1/4">
                <select name="status"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Todos</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activos</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </div>

            <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">Filtrar</button>
        </form>

        <!-- Tabla de usuarios -->
        <div class="bg-white shadow-md rounded-lg p-4 overflow-x-auto">
            <table class="w-full table-auto text-sm">
                <thead>
                    <tr class="bg-gray-100 text-left">
                        <th class="px-4 py-2">ID</th>
                        <th class="px-4 py-2">Nombre</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Estado</th>
                        <th class="px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">
                                @if($user->is_active)
                                    <span class="text-green-600 font-semibold">Activo</span>
                                @else
                                    <span class="text-red-600 font-semibold">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <button
                                    @click="isOpen = true; modalType = 'edit'; selectedUserId = {{ $user->id }}"
                                    class="text-blue-600 hover:underline flex items-center space-x-1"
                                    title="Editar">
                                    <i data-feather="edit"></i>
                                    <span>Editar</span>
                                </button>

                                <button
                                    @click="isOpen = true; modalType = 'reset'; selectedUserId = {{ $user->id }}"
                                    class="text-yellow-600 hover:underline flex items-center space-x-1"
                                    title="Resetear contraseña">
                                    <i data-feather="refresh-ccw"></i>
                                    <span>Resetear</span>
                                </button>

                                <button
                                    @click="isOpen = true; modalType = 'delete'; selectedUserId = {{ $user->id }}"
                                    class="text-red-600 hover:underline flex items-center space-x-1"
                                    title="Eliminar">
                                    <i data-feather="trash-2"></i>
                                    <span>Eliminar</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">No se encontraron usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>

        <!-- Modal dinámico -->
        <div x-show="isOpen" style="display: none;"
            class="fixed inset-0 z-50 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white w-full max-w-md p-6 rounded shadow-xl">
                <!-- EDITAR -->
                <template x-if="modalType === 'edit'">
                    <div>
                        <h2 class="text-xl font-bold mb-4">Editar Usuario <span x-text="selectedUserId"></span></h2>
                        <!-- Formulario o contenido -->
                        <button @click="isOpen = false"
                            class="mt-4 bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Cerrar</button>
                    </div>
                </template>

                <!-- RESET -->
                <template x-if="modalType === 'reset'">
                    <div>
                        <h2 class="text-xl font-bold mb-4">Resetear contraseña</h2>
                        <p>¿Deseas resetear la contraseña del usuario con ID <span x-text="selectedUserId"></span>?</p>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button @click="isOpen = false"
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                            <button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                                Confirmar
                            </button>
                        </div>
                    </div>
                </template>

                <!-- ELIMINAR -->
                <template x-if="modalType === 'delete'">
                    <div>
                        <h2 class="text-xl font-bold mb-4 text-red-600">Eliminar Usuario</h2>
                        <p>¿Deseas eliminar al usuario con ID <span x-text="selectedUserId"></span>?</p>
                        <div class="mt-4 flex justify-end space-x-2">
                            <button @click="isOpen = false"
                                class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded">Cancelar</button>
                            <button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                                Eliminar
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- Feather Icons -->
    @push('scripts')
        <script src="https://unpkg.com/feather-icons"></script>
        <script>
            document.addEventListener('alpine:initialized', () => feather.replace());
            document.addEventListener('alpine:reinitialized', () => feather.replace());
        </script>
    @endpush
</x-app-layout>
