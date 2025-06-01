<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        @if (session('success'))
            <div class="bg-green-700 text-white px-4 py-3 rounded-lg mb-6 shadow-md border border-green-800 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-700 text-white px-4 py-3 rounded-lg mb-6 shadow-md border border-red-800 animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold text-white mb-6">Gestión de Entrenadores</h1>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <a href="{{ route('admin-entrenador.entrenadores.create') }}"
                class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition duration-200 transform hover:scale-105 min-w-[180px]">
                <i data-feather="user-plus" class="w-5 h-5 mr-2"></i> Agregar
            </a>

            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition duration-200 transform hover:scale-105 min-w-[180px]">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
            <table class="min-w-full table-auto divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Correo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($entrenadores as $entrenador)
                        <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-4 py-3 text-white">{{ $entrenador->name ?? 'Nombre no disponible' }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $entrenador->email ?? 'Correo no disponible' }}</td>
                            <td class="px-4 py-3 flex items-center space-x-4">
                                <a href="{{ route('admin-entrenador.entrenadores.edit', $entrenador) }}"
                                    class="text-yellow-400 hover:text-yellow-500 font-medium transition duration-200">
                                    Editar
                                </a>

                                <form action="{{ route('admin-entrenador.entrenadores.darBaja', $entrenador->id) }}"
                                    method="POST" class="inline">
                                    @csrf
                                    @method('POST') {{-- O DELETE si es una baja definitiva --}}
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-medium transition duration-200">
                                        Dar Baja
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-4 text-center text-gray-400">No hay entrenadores registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
