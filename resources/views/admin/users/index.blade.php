<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto" x-data="userModals()">
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

<!-- Buscador por nombre o correo -->
<form method="GET" action="{{ route('admin.usuarios.index') }}" id="searchForm"
    class="mb-4 bg-white p-4 rounded-lg shadow flex flex-wrap items-center gap-4">
    <div class="w-full sm:w-auto flex-1">
        <label for="search" class="block text-sm font-medium text-gray-700">Buscar por nombre o correo</label>
        <input type="text" name="search" id="search" value="{{ request('search') }}"
            placeholder="Ej. Juan o juan@email.com"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    </div>

    <div class="self-end">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-medium transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" />
            </svg>
            Buscar
        </button>
    </div>
</form>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Roles
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-700 text-sm">
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
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Activo
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-1">
                                <!-- Editar -->
                                <button
                                    @click="openModal('edit', {{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}')"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-400 hover:bg-yellow-500 text-white rounded-md"
                                    title="Editar usuario">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M11 5h2M7 21v-2a4 4 0 014-4h6" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M18.364 5.636a2 2 0 112.828 2.828l-9.192 9.192a4 4 0 01-1.414.586l-3.536 1.178a1 1 0 01-1.274-1.274l1.178-3.536a4 4 0 01.586-1.414l9.192-9.192z" />
                                    </svg>
                                </button>

                                <!-- Resetear contraseña -->
                                <button
                                    @click="openModal('reset', {{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-xs font-semibold transition-colors duration-200"
                                    title="Resetear contraseña">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 4v1m0 14v1m8-8h1M3 12H2m15.364-6.364l.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z" />
                                    </svg>
                                </button>

                                <!-- Cambiar estado -->
                                <button
                                    @click="openModal('changeStatus', {{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="inline-flex items-center px-2 py-1 bg-gray-600 hover:bg-gray-700 text-white rounded-md text-xs font-semibold transition-colors duration-200"
                                    title="Cambiar estado usuario">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12H9m6 0a6 6 0 11-6-6m6 6a6 6 0 01-6 6" />
                                    </svg>
                                </button>

                                <!-- Eliminar -->
                                <button
                                    @click="openModal('delete', {{ $user->id }}, '{{ addslashes($user->name) }}')"
                                    class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs font-semibold transition-colors duration-200"
                                    title="Eliminar usuario">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
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

        <!-- Modales -->
        <div x-show="isOpen" style="display: none"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div @click.away="closeModal()" class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
                <button @click="closeModal()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-900 text-2xl font-bold">&times;</button>

                <template x-if="modalType === 'edit'">
                    <form :action="/admin/users / $ { selectedUserId }
                    /edit" method="GET" class="space-y-4">
                        <h3 class="text-lg font-semibold">Editar usuario: <span x-text="selectedUserName"></span></h3>

                        <div>
                            <label for="name" class="block font-medium text-gray-700">Nombre</label>
                            <input type="text" id="name" name="name" x-model="selectedUserName" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label for="email" class="block font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" x-model="selectedUserEmail" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 bg-yellow-400 text-white rounded hover:bg-yellow-500">Guardar</button>
                        </div>
                    </form>
                </template>

                <template x-if="modalType === 'reset'">
                    <form :action="/admin/users / $ { selectedUserId }
                    /resetPassword" method="POST">
                        @csrf
                        <h3 class="text-lg font-semibold">Resetear contraseña de: <span
                                x-text="selectedUserName"></span></h3>
                        <p class="my-4">¿Estás seguro que quieres resetear la contraseña?</p>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700">Confirmar</button>
                        </div>
                    </form>
                </template>

                <template x-if="modalType === 'changeStatus'">
                    <form :action="/admin/users / $ { selectedUserId }
                    /changeStatus" method="POST">
                        @csrf
                        <h3 class="text-lg font-semibold">Cambiar estado de: <span x-text="selectedUserName"></span>
                        </h3>
                        <p class="my-4">¿Confirmas cambiar el estado del usuario?</p>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">Confirmar</button>
                        </div>
                    </form>
                </template>

                <template x-if="modalType === 'delete'">
                    <form :action="/admin/users / $ { selectedUserId }" method="POST">
                        @csrf
                        @method('DELETE')
                        <h3 class="text-lg font-semibold text-red-600">Eliminar usuario: <span
                                x-text="selectedUserName"></span></h3>
                        <p class="my-4 text-red-700">¿Estás seguro que quieres eliminar este usuario? Esta acción no se
                            puede deshacer.</p>

                        <div class="flex justify-end space-x-2">
                            <button type="button" @click="closeModal()"
                                class="px-4 py-2 bg-gray-300 rounded">Cancelar</button>
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                        </div>
                    </form>
                </template>
            </div>
        </div>
    </div>

    <script>
        function userModals() {
            return {
                isOpen: false,
                modalType: '',
                selectedUserId: null,
                selectedUserName: '',
                selectedUserEmail: '',

                openModal(type, id, name, email = '') {
                    this.modalType = type;
                    this.selectedUserId = id;
                    this.selectedUserName = name;
                    this.selectedUserEmail = email;
                    this.isOpen = true;
                },

                closeModal() {
                    this.isOpen = false;
                    this.modalType = '';
                    this.selectedUserId = null;
                    this.selectedUserName = '';
                    this.selectedUserEmail = '';
                }
            }
        }
    </script>
</x-app-layout>
