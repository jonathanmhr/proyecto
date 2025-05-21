<x-app-layout>
    <h1 class="text-3xl font-bold mb-6">Panel de usuarios</h1>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
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
                                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-semibold
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
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Activo</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center space-x-1">
                                <!-- Botón Eliminar -->
                                <button onclick="openModal('modal-delete-{{ $user->id }}')" class="text-red-600 hover:text-red-800">
                                    <i data-feather="trash-2"></i>
                                </button>

                                <!-- Botón Activar/Desactivar -->
                                <button onclick="openModal('modal-toggle-{{ $user->id }}')" class="text-gray-600 hover:text-gray-800">
                                    <i data-feather="toggle-left"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal de Eliminar -->
                        <div id="modal-delete-{{ $user->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">¿Eliminar usuario?</h2>
                                <p class="text-gray-600 mb-6">Esta acción no se puede deshacer.</p>
                                <div class="flex justify-end gap-4">
                                    <button onclick="closeModal('modal-delete-{{ $user->id }}')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-gray-800">Cancelar</button>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Activar/Desactivar -->
                        <div id="modal-toggle-{{ $user->id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
                            <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
                                <h2 class="text-xl font-semibold text-gray-800 mb-4">
                                    ¿{{ $user->is_active ? 'Desactivar' : 'Activar' }} usuario?
                                </h2>
                                <p class="text-gray-600 mb-6">
                                    ¿Seguro que quieres {{ $user->is_active ? 'desactivar' : 'activar' }} a este usuario?
                                </p>
                                <div class="flex justify-end gap-4">
                                    <button onclick="closeModal('modal-toggle-{{ $user->id }}')" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded text-gray-800">Cancelar</button>
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
    </div>

    <!-- JS para modales -->
    @push('scripts')
    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }
    </script>
    @endpush
</x-app-layout>
