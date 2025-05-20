<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <!-- Alertas -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2l4-4m5 4a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded flex items-center mb-4">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                {{ session('error') }}
            </div>
        @endif

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

            <div class="flex items-center gap-2">
                <label for="role" class="text-sm font-medium text-gray-700">Filtrar por rol:</label>
                <select name="role" id="role"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm"
                    onchange="this.form.submit()">
                    <option value="">Todos</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="admin_entrenador" {{ request('role') == 'admin_entrenador' ? 'selected' : '' }}>Admin Entrenador</option>
                    <option value="entrenador" {{ request('role') == 'entrenador' ? 'selected' : '' }}>Entrenador</option>
                    <option value="cliente" {{ request('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md transition">
                Buscar
            </button>
        </form>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-600 text-white text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Creado</th>
                        <th class="px-6 py-3 text-left">Roles</th>
                        <th class="px-6 py-3 text-left">Estado</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-5 text-sm font-medium text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-5 text-sm">
                                @if ($user->roles->isEmpty())
                                    <span class="text-gray-400 italic">Sin rol</span>
                                @else
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                                            {{ $role->name === 'admin' ? 'bg-blue-100 text-blue-800'
                                                : ($role->name === 'cliente' ? 'bg-green-100 text-green-800'
                                                : ($role->name === 'entrenador' ? 'bg-yellow-100 text-yellow-800'
                                                : 'bg-purple-100 text-purple-800')) }}">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </td>

                            <td class="px-6 py-5 text-sm">
                                <form method="POST" action="{{ route('admin.users.changeStatus', $user->id) }}">
                                    @csrf
                                    <select name="status" onchange="this.form.submit()"
                                        class="border rounded px-2 py-1 text-xs">
                                        <option value="activo" {{ $user->status == 'activo' ? 'selected' : '' }}>Activo</option>
                                        <option value="inactivo" {{ $user->status == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                                        <option value="suspendido" {{ $user->status == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                                    </select>
                                </form>
                            </td>

                            <td class="px-6 py-5 text-sm text-gray-800">
                                <div class="flex flex-wrap gap-2 items-center">

                                    <!-- Editar -->
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-xs font-semibold">
                                        Editar
                                    </a>

                                    <!-- Resetear contraseña -->
                                    <form action="{{ route('admin.users.resetPassword', $user->id) }}" method="POST"
                                        onsubmit="return confirm('¿Confirmar reset de contraseña?');">
                                        @csrf
                                        <button type="submit"
                                            class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-1 rounded-md text-xs font-semibold">
                                            Resetear contraseña
                                        </button>
                                    </form>

                                    <!-- Asignar rol -->
                                    <form method="POST" action="{{ route('admin.users.assignRole', $user->id) }}"
                                        class="flex gap-1 items-center">
                                        @csrf
                                        <select name="role"
                                            class="border border-gray-300 rounded-md px-2 py-1 text-xs text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm"
                                            required>
                                            <option value="" disabled selected>Rol</option>
                                            <option value="admin">Administrador</option>
                                            <option value="admin_entrenador">Admin Entrenador</option>
                                            <option value="entrenador">Entrenador</option>
                                            <option value="cliente">Cliente</option>
                                        </select>
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white text-xs px-2 py-1 rounded-md flex items-center gap-1 transition-transform transform hover:scale-105">
                                            Asignar
                                        </button>
                                    </form>

                                    <!-- Botón eliminar con modal -->
                                    <button
                                        @click="openModal({{ $user->id }}, '{{ $user->name }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white text-xs px-3 py-1 rounded-md flex items-center gap-1 transition-transform transform hover:scale-105"
                                        type="button">
                                        Eliminar
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="py-6">
                <div class="flex justify-center">
                    {{ $users->links() }}
                </div>

                <div class="mt-4 text-center text-sm text-gray-600">
                    Mostrando
                    <span class="font-semibold">{{ $users->firstItem() }}</span> al
                    <span class="font-semibold">{{ $users->lastItem() }}</span> de
                    <span class="font-semibold">{{ $users->total() }}</span> resultados
                </div>
            </div>
        </div>
    </div>

    <!-- Modal eliminar usuario -->
    <div
        x-data="{
            isOpen: false,
            userId: null,
            userName: '',
            openModal(id, name) {
                this.userId = id;
                this.userName = name;
                this.isOpen = true;
            },
            closeModal() {
                this.isOpen = false;
                this.userId = null;
                this.userName = '';
            }
        }"
        x-cloak
        x-show="isOpen"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
    >
        <div @click.away="closeModal()" class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h3 class="text-lg font-semibold mb-4">Confirmar eliminación</h3>
            <p class="mb-6">¿Estás seguro que quieres eliminar al usuario <strong x-text="userName"></strong>?</p>

            <form :action="`{{ url('admin/users') }}/${userId}`" method="POST" class="flex justify-end gap-4">
                @csrf
                @method('DELETE')
                <button type="button" @click="closeModal()" class="px-4 py-2 rounded border border-gray-300 hover:bg-gray-100 transition">
                    Cancelar
                </button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 transition">
                    Eliminar
                </button>
            </form>
        </div>
    </div>

    <!-- Alpine.js para modal -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        function liveSearch() {
            const input = document.getElementById('search');
            const value = input.value.trim();
            const error = document.getElementById('error-message');
            if (value.length < 3 || value.length > 100) {
                error.classList.remove('hidden');
                return;
            }
            error.classList.add('hidden');
            window.location.href = `?search=${value}`;
        }
    </script>
</x-app-layout>
