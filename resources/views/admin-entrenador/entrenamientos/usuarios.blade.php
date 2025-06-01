<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-white leading-tight">
                Usuarios del Entrenamiento: <span class="text-red-500">{{ $entrenamiento->nombre }}</span>
            </h2>

            <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>
    </x-slot>

    {{-- Contenedor principal con fondo oscuro --}}
    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-gray-900 text-gray-100 min-h-screen">
        {{-- Mensajes flash --}}
        @if (session('success'))
            <div class="mb-4 bg-green-700 text-white px-4 py-3 rounded-lg shadow-md border border-green-800 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 bg-red-700 text-white px-4 py-3 rounded-lg shadow-md border border-red-800 animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        {{-- Formulario para agregar múltiples usuarios --}}
        <div class="bg-gray-800 p-6 shadow-lg rounded-xl mb-6 border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">Agregar usuarios al entrenamiento</h3>
            <form
                action="{{ route('admin-entrenador.entrenamientos.usuarios.agregar-masivos', $entrenamiento->id_entrenamiento) }}"
                method="POST" class="flex flex-col sm:flex-row gap-4 items-center">
                @csrf
                <select name="usuario_ids[]" multiple
                    class="border border-gray-600 rounded-lg px-4 py-3 w-full sm:w-1/2 bg-gray-700 text-white focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200">
                    @forelse ($usuarios as $usuario)
                        @if (!$entrenamiento->usuarios->contains($usuario->id))
                            <option value="{{ $usuario->id }}" class="text-gray-200">{{ $usuario->name }} ({{ $usuario->email }})</option>
                        @endif
                    @empty
                        <option value="" disabled>No hay usuarios disponibles para agregar.</option>
                    @endforelse
                </select>
                <button type="submit" class="bg-red-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-red-700 shadow-md transition duration-200 transform hover:scale-105 w-full sm:w-auto">
                    Agregar a los seleccionados
                </button>
            </form>
        </div>

        {{-- Lista de usuarios asignados --}}
        <div class="bg-gray-800 p-6 shadow-lg rounded-xl border border-gray-700">
            <h3 class="text-lg font-bold text-white mb-4">Usuarios asignados</h3>

            @if ($entrenamiento->usuarios->isEmpty())
                <p class="text-gray-400 text-center py-4">No hay usuarios asignados a este entrenamiento.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-700">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nombre</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Email</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($entrenamiento->usuarios as $usuario)
                                <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td class="px-4 py-3 text-white">{{ $usuario->name }}</td>
                                    <td class="px-4 py-3 text-gray-300">{{ $usuario->email }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <form
                                            action="{{ route('admin-entrenador.entrenamientos.usuarios.quitar', [$entrenamiento->id_entrenamiento, $usuario->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Estás seguro de quitar a este usuario del entrenamiento? Esta acción no se puede deshacer.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-600 font-medium transition duration-200">
                                                Quitar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
