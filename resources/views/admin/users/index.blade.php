<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 border border-green-300 rounded-md px-4 py-2 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-9.707a1 1 0 00-1.414 0L9 10.586 8.707 10.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 8.586l.707-.707z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 text-red-800 border border-red-300 rounded-md px-4 py-2 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-9.707a1 1 0 00-1.414 0L9 10.586 8.707 10.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4a1 1 0 00-1.414-1.414L11 8.586l.707-.707z" clip-rule="evenodd"/>
                </svg>
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <!-- Formulario de búsqueda -->
            <div class="mb-6 flex justify-between items-center">
                <div class="flex space-x-4">
                    <input type="text" id="search" placeholder="Buscar por nombre o email"
                        class="border border-gray-300 rounded-md px-4 py-2 text-sm" 
                        value="{{ request('search') }}" onkeyup="liveSearch()">
                    <p id="error-message" class="text-red-500 text-sm mt-2 hidden">Por favor, ingresa entre 3 y 8 caracteres para la búsqueda.</p>
                </div>
                <div>
                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-md transition"
                        onclick="liveSearch()">Buscar</button>
                </div>
            </div>

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-blue-500 text-white text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nombre</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Cuenta creada</th>
                        <th class="px-6 py-3 text-left">Rol</th>
                        <th class="px-6 py-3 text-left">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                {{ $user->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                @if ($user->roles->isEmpty())
                                    <span class="text-sm text-gray-500 italic">Sin rol</span>
                                @else
                                    <span class="text-sm text-gray-700">{{ $user->roles->pluck('name')->join(', ') }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                <div class="flex items-center space-x-4">
                                    <!-- Desplegable de rol -->
                                    <form method="POST" action="{{ route('admin.users.assignRole', $user->id) }}"
                                        class="flex items-center space-x-2">
                                        @csrf
                                        <select name="role"
                                            class="border border-gray-300 rounded-md px-4 py-2 text-sm text-gray-700">
                                            <option value="" disabled selected>Seleccionar</option>
                                            <option value="admin">Administrador</option>
                                            <option value="admin_entrenador">Admin Entrenador</option>
                                            <option value="entrenador">Entrenador</option>
                                            <option value="cliente">Cliente</option>
                                        </select>
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-md transition">
                                            Asignar
                                        </button>
                                    </form>

                                    <!-- Botón de eliminar usuario -->
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                        class="mt-2 inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-md transition">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación estilizada -->
            <div class="mt-4">
                <div class="flex justify-center">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
