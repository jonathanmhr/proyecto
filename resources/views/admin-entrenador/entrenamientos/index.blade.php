<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight">
            {{ __('Gestión de Entrenamientos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Botón Crear -->
            <div class="mb-4">
                <a href="{{ route('admin-entrenador.entrenamientos.create') }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Crear Entrenamiento
                </a>
            </div>

            <!-- Tabla -->
            <div class="bg-white shadow-sm rounded-lg p-4">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2">Nombre</th>
                            <th class="px-4 py-2">Tipo</th>
                            <th class="px-4 py-2">Duración</th>
                            <th class="px-4 py-2">Fecha</th>
                            <th class="px-4 py-2">Usuarios</th>
                            <th class="px-4 py-2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entrenamientos as $entrenamiento)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $entrenamiento->nombre }}</td>
                            <td class="px-4 py-2">{{ $entrenamiento->tipo }}</td>
                            <td class="px-4 py-2">{{ $entrenamiento->duracion }} min</td>
                            <td class="px-4 py-2">{{ $entrenamiento->fecha }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin-entrenador.entrenamientos.usuarios', $entrenamiento->id_entrenamiento) }}"
                                   class="text-blue-600 hover:underline">
                                   Ver ({{ $entrenamiento->usuarios->count() }})
                                </a>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin-entrenador.entrenamientos.edit', $entrenamiento->id_entrenamiento) }}"
                                   class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('admin-entrenador.entrenamientos.destroy', $entrenamiento->id_entrenamiento) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este entrenamiento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
