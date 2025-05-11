<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Lista de Entrenamientos</h1>
        
        <!-- Botón para crear nuevo entrenamiento -->
        <div class="mb-4">
            <a href="{{ route('admin-entrenador.entrenamientos.create') }}" 
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">
                Crear Nuevo Entrenamiento
            </a>
        </div>
        
        <!-- Tabla de entrenamientos -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-600">Nombre</th>
                        <th class="py-3 px-4 text-left text-gray-600">Tipo</th>
                        <th class="py-3 px-4 text-left text-gray-600">Duración</th>
                        <th class="py-3 px-4 text-left text-gray-600">Fecha</th>
                        <th class="py-3 px-4 text-center text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($entrenamientos as $entrenamiento)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $entrenamiento->nombre }}</td>
                            <td class="py-3 px-4">{{ $entrenamiento->tipo }}</td>
                            <td class="py-3 px-4">{{ $entrenamiento->duracion }} min</td>
                            <td class="py-3 px-4">{{ $entrenamiento->fecha }}</td>
                            <td class="py-3 px-4 text-center">
                                <a href="{{ route('admin-entrenador.entrenamientos.show', $entrenamiento->id_entrenamiento) }}" 
                                   class="text-green-600 hover:text-green-800">Ver</a>
                                |
                                <a href="{{ route('admin-entrenador.entrenamientos.edit', $entrenamiento->id_entrenamiento) }}" 
                                   class="text-blue-600 hover:text-blue-800">Editar</a>
                                |
                                <form action="{{ route('admin-entrenador.entrenamientos.destroy', $entrenamiento->id_entrenamiento) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
