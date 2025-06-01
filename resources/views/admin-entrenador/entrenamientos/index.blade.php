<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight overflow-hidden truncate">
            {{ __('Gestión de Entrenamientos') }}
        </h2>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="mb-6 flex justify-between items-center">
            <a href="{{ route('admin-entrenador.entrenamientos.create') }}"
                class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-xl shadow-md transition duration-200 transform hover:scale-105 min-w-[180px]">
                <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i> Crear Entrenamiento
            </a>

            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition duration-200 transform hover:scale-105 min-w-[180px]">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        {{-- Mensajes de sesión (éxito/error) --}}
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

        <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Tipo</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Duración</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Usuarios</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($entrenamientos as $entrenamiento)
                        <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-4 py-3 text-white">{{ $entrenamiento->nombre }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $entrenamiento->tipo }}</td>
                            <td class="px-4 py-3 text-gray-300">{{ $entrenamiento->duracion }} min</td>
                            <td class="px-4 py-3 text-gray-300">{{ $entrenamiento->fecha }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin-entrenador.entrenamientos.usuarios', $entrenamiento->id_entrenamiento) }}"
                                    class="text-blue-400 hover:text-blue-500 font-medium transition duration-200">
                                    Ver ({{ $entrenamiento->usuarios->count() }})
                                </a>
                            </td>
                            <td class="px-4 py-3 space-x-4"> {{-- Increased space-x for better separation --}}
                                <a href="{{ route('admin-entrenador.entrenamientos.edit', $entrenamiento->id_entrenamiento) }}"
                                    class="text-yellow-400 hover:text-yellow-500 font-medium transition duration-200">Editar</a>
                                <form
                                    action="{{ route('admin-entrenador.entrenamientos.destroy', $entrenamiento->id_entrenamiento) }}"
                                    method="POST" class="inline-block"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este entrenamiento? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600 font-medium transition duration-200">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-gray-400">No hay entrenamientos disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
