<x-app-layout>
    <div class="container mx-auto mt-6">
        <h2 class="text-2xl font-bold mb-4">Gestión de Entrenadores</h2>


        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <!-- Botón Agregar Entrenador -->
            <a href="{{ route('admin-entrenador.entrenadores.create') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="user-plus" class="w-4 h-4"></i> Agregar
            </a>

            <!-- Botón Volver -->
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver
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
                                <a href="{{ route('admin-entrenador.entrenadores.edit', $entrenador) }}"
                                    class="text-blue-500 hover:text-blue-700">
                                    Editar
                                </a>

                                <form action="{{ route('entrenadores.eliminar', $entrenador->id) }}" method="POST" class="inline">
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
