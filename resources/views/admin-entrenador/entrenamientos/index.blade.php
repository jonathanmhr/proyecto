<x-app-layout>
    <div class="container mx-auto py-6">
        <div class="mb-4 flex justify-between">
            <a href="{{ route('admin-entrenador.entrenamientos.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Crear Entrenamiento
            </a>
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Listado de Entrenamientos</h2>

            <!-- Listado de entrenamientos -->
            @foreach($entrenamientos as $entrenamiento)
                <div class="flex justify-between items-center mb-4">
                    <span>{{ $entrenamiento->nombre }}</span>
                    <div>
                        <a href="{{ route('admin-entrenador.entrenamientos.edit', $entrenamiento) }}" 
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            Editar
                        </a>
                        <!-- Botón de Eliminar -->
                        <button onclick="openDeleteModal('{{ route('admin-entrenador.entrenamientos.destroy', $entrenamiento) }}')" 
                            class="ml-2 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Eliminar
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div id="confirmDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-50 hidden">
        <div class="bg-white rounded-lg p-6 w-96">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">¿Estás seguro de que deseas eliminar este entrenamiento?</h3>
            <div class="flex justify-between items-center">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-700 hover:bg-gray-400 rounded-lg">
                    Cancelar
                </button>
                <form id="deleteForm" method="POST" action="" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded-lg">
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Script para controlar el modal -->
    <script>
        // Función para abrir el modal
        function openDeleteModal(deleteUrl) {
            // Mostrar el modal
            document.getElementById('confirmDeleteModal').classList.remove('hidden');

            // Asignar la URL de eliminación al formulario
            document.getElementById('deleteForm').action = deleteUrl;
        }

        // Función para cerrar el modal
        document.getElementById('cancelDelete').addEventListener('click', function() {
            document.getElementById('confirmDeleteModal').classList.add('hidden');
        });
    </script>
</x-app-layout>
