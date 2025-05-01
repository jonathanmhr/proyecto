<x-app-layout>
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Gestión de Entrenadores</h2>
        
        <!-- Botón para agregar nuevos entrenadores -->
        <div class="mb-4">
            <a href="{{ route('admin-entrenador.entrenadores.create') }}" 
                class="inline-block bg-blue-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-blue-700">
                Agregar Entrenador
            </a>
        </div>
        
        <!-- Tabla de Entrenadores -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-700">Nombre</th>
                        <th class="px-4 py-2 text-left text-gray-700">Correo</th>
                        <th class="px-4 py-2 text-left text-gray-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entrenadores as $entrenador)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $entrenador->name }}</td>
                            <td class="px-4 py-2">{{ $entrenador->email }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <!-- Editar Entrenador -->
                                <a href="{{ route('admin-entrenador.entrenadores.edit', $entrenador->id) }}" 
                                    class="text-blue-500 hover:text-blue-700">
                                    Editar
                                </a>
                                
                                <!-- Eliminar Entrenador -->
                                <form action="{{ route('admin-entrenador.entrenadores.eliminar', $entrenador->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('POST')
                                    <button type="submit" class="text-red-500 hover:text-red-700">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
