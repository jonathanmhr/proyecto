<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <h1 class="text-3xl font-bold mb-6">Gestión de usuarios</h1>

        <!-- Filtros y búsqueda -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <input type="text" name="search" placeholder="Buscar por nombre o email"
                    value="{{ request('search') }}"
                    class="w-full md:w-64 px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-indigo-200 focus:outline-none">
                
                <select name="role" class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-indigo-200">
                    <option value="">Todos los roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="entrenador" {{ request('role') == 'entrenador' ? 'selected' : '' }}>Entrenador</option>
                    <option value="cliente" {{ request('role') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>

                <select name="estado" class="px-4 py-2 border border-gray-300 rounded-md focus:ring focus:ring-indigo-200">
                    <option value="">Todos los estados</option>
                    <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Filtrar</button>
            </form>
        </div>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr class="text-left">
                        <th class="px-6 py-3">Nombre</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Roles</th>
                        <th class="px-6 py-3 text-center">Estado</th>
                        <th class="px-6 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach ($user->roles as $role)
                                    <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                                        {{ $role->name === 'admin' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $role->name === 'entrenador' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $role->name === 'cliente' ? 'bg-blue-100 text-blue-700' : '' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center space-x-1">
                                <!-- Eliminar -->
                                <button onclick="openModal('modal-delete-{{ $user->id }}')" class="text-red-600 hover:text-red-800">
                                    <i data-feather="trash-2"></i>
                                </button>

                                <!-- Activar / Desactivar -->
                                <button onclick="openModal('modal-toggle-{{ $user->id }}')" class="text-gray-600 hover:text-gray-800">
                                    <i data-feather="toggle-left"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Eliminar -->
                        <div id="modal-delete-{{ $user->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                                <h2 class="text-xl font-semibold mb-4 text-gray-800">¿Eliminar usuario?</h2>
                                <p class="text-gray-600 mb-6">Esta acción no se puede deshacer.</p>
                                <div class="flex justify-end gap-4">
                                    <button onclick="closeModal('modal-delete-{{ $user->id }}')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancelar</button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Activar/Desactivar -->
                        <div id="modal-toggle-{{ $user->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                                <h2 class="text-xl font-semibold mb-4 text-gray-800">
                                    ¿{{ $user->is_active ? 'Desactivar' : 'Activar' }} usuario?
                                </h2>
                                <p class="text-gray-600 mb-6">
                                    ¿Estás seguro que deseas {{ $user->is_active ? 'desactivar' : 'activar' }} este usuario?
                                </p>
                                <div class="flex justify-end gap-4">
                                    <button onclick="closeModal('modal-toggle-{{ $user->id }}')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded">Cancelar</button>
                                    <form action="{{ route('admin.users.changeStatus', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded">
                                            {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-6">
            {{ $users->appends(request()->query())->links() }}
        </div>
    </div>

    @push('scripts')
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (typeof feather !== 'undefined') {
                feather.replace();
            }
        });
    </script>
    @endpush
</x-app-layout>
