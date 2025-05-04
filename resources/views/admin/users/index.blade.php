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

        <!-- Buscador -->
        <div
            class="bg-white shadow-md rounded-lg mb-6 p-4 flex flex-col md:flex-row md:justify-between items-center gap-4">
            <div class="relative w-full md:w-1/2">
                <input type="text" id="search" placeholder="Buscar por nombre o email"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}">
                <p id="error-message" class="text-red-500 text-sm mt-1 hidden">
                    Por favor, ingresa entre 3 y 8 caracteres para la búsqueda.
                </p>
            </div>
            <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-md transition"
                onclick="liveSearch()">
                Buscar
            </button>
        </div>

        <!-- Tabla de usuarios -->
        <div class="overflow-x-auto bg-white shadow-xl rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-600 text-white text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Cuenta creada</th>
                        <th class="px-6 py-3 text-left">Rol</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-5 text-sm font-medium text-gray-900">{{ $user->id }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-5 text-sm text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-5 text-sm">
                                @if ($user->roles->isEmpty())
                                    <span class="text-gray-400 italic">Sin rol</span>
                                @else
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="inline-block px-2 py-1 rounded-full text-xs font-semibold 
                                                    {{ $role->name === 'admin'
                                                        ? 'bg-blue-100 text-blue-800'
                                                        : ($role->name === 'cliente'
                                                            ? 'bg-green-100 text-green-800'
                                                            : ($role->name === 'entrenador'
                                                                ? 'bg-yellow-100 text-yellow-800'
                                                                : 'bg-purple-100 text-purple-800')) }}">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-6 py-5 text-sm text-gray-800">
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

                                    <!-- Eliminar -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-md flex items-center gap-1 transition-transform transform hover:scale-105">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
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
            
                {{-- Texto de rango de resultados --}}
                <div class="mt-4 text-center text-sm text-gray-600">
                    Mostrando
                    <span class="font-semibold">{{ $users->firstItem() }}</span> al
                    <span class="font-semibold">{{ $users->lastItem() }}</span> de
                    <span class="font-semibold">{{ $users->total() }}</span> resultados
                </div>
            </div>     
        </div>
    </div>

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
