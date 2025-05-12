<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <!-- Título -->
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Usuarios del Entrenamiento: {{ $entrenamiento->nombre }}
            </h2>

            <!-- Botón Volver -->
            <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Mensajes flash --}}
        @if (session('success'))
            <div class="mb-4 text-green-600 font-semibold">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario para agregar múltiples usuarios --}}
        <div class="bg-white p-6 shadow rounded-lg mb-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Agregar usuarios al entrenamiento</h3>
            <form
                action="{{ route('admin-entrenador.entrenamientos.usuarios.agregar-masivos', $entrenamiento->id_entrenamiento) }}"
                method="POST" class="flex flex-col sm:flex-row gap-4 items-center">
                @csrf
                <select name="usuario_ids[]" class="border rounded px-4 py-2 w-full sm:w-1/2" multiple>
                    @foreach ($usuarios as $usuario)
                        @if (!$entrenamiento->usuarios->contains($usuario->id))
                            <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                        @endif
                    @endforeach
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Agregar a los seleccionados
                </button>
            </form>
        </div>

        {{-- Lista de usuarios asignados --}}
        <div class="bg-white p-6 shadow rounded-lg">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Usuarios asignados</h3>

            @if ($entrenamiento->usuarios->isEmpty())
                <p class="text-gray-500">No hay usuarios asignados a este entrenamiento.</p>
            @else
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left">Nombre</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entrenamiento->usuarios as $usuario)
                            <tr class="border-t">
                                <td class="px-4 py-2">{{ $usuario->name }}</td>
                                <td class="px-4 py-2">{{ $usuario->email }}</td>
                                <td class="px-4 py-2 text-center">
                                    <form
                                        action="{{ route('admin-entrenador.entrenamientos.usuarios.quitar', [$entrenamiento->id_entrenamiento, $usuario->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de quitar a este usuario del entrenamiento?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                            Quitar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
