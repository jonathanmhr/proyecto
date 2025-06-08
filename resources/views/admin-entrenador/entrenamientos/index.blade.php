<x-app-layout>
    {{-- La slot 'header' de x-app-layout ya no se usa si todo está dentro del container --}}
    {{-- <x-slot name="header">
        <h2 class="text-xl font-semibold">Entrenamientos</h2>
    </x-slot> --}}

    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        {{-- Título de la página --}}
        <h1 class="text-4xl font-extrabold mb-8 text-white text-center md:text-left">Gestión de Entrenamientos</h1>

        {{-- Botón para crear nuevo entrenamiento --}}
        <div class="flex justify-start mb-8"> {{-- Usamos justify-start para alinear a la izquierda --}}
            <a href="{{ route('admin-entrenador.entrenamientos.create') }}"
               class="flex items-center bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i> Crear nuevo entrenamiento
            </a>
        </div>

        {{-- Contenedor principal de la tabla --}}
        <div class="bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6">
            @if($entrenamientos->isEmpty())
                {{-- Mensaje para cuando no hay entrenamientos, usando la paleta --}}
                <div class="bg-gray-700 border-l-4 border-red-600 text-gray-100 p-4 rounded-md" role="alert">
                    <p class="font-bold mb-1">¡Vaya, no hay entrenamientos todavía!</p>
                    <p>Parece que aún no has creado ningún entrenamiento. ¡Anímate a añadir el primero!</p>
                </div>
            @else
                {{-- Tabla de entrenamientos --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto divide-y divide-gray-700">
                        <thead>
                            <tr class="bg-gray-700">
                                <th class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tl-lg">
                                    Título
                                </th>
                                <th class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                    Nivel
                                </th>
                                <th class="px-5 py-3 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                    Usuarios guardados
                                </th>
                                <th class="px-5 py-3 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tr-lg">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($entrenamientos as $entrenamiento)
                                <tr class="hover:bg-gray-750 transition duration-150 ease-in-out">
                                    <td class="px-5 py-4 text-white font-medium">
                                        {{ $entrenamiento->titulo }}
                                    </td>
                                    <td class="px-5 py-4 capitalize text-gray-300">
                                        {{ $entrenamiento->nivel }}
                                    </td>
                                    <td class="px-5 py-4 text-center">
                                        <a href="{{ route('entrenamientos.usuarios', $entrenamiento->id) }}"
                                           class="text-blue-400 hover:text-blue-500 underline font-medium"
                                           title="Ver usuarios que guardaron este entrenamiento">
                                            {{ $entrenamiento->usuariosGuardaron->count() }}
                                        </a>
                                    </td>
                                    <td class="px-5 py-4 flex items-center justify-center space-x-4">
                                        <a href="{{ route('entrenamientos.edit', $entrenamiento->id) }}"
                                           class="text-blue-400 hover:text-blue-500 transition duration-200 flex items-center"
                                           title="Editar entrenamiento" aria-label="Editar">
                                           <i data-feather="edit" class="w-4 h-4 mr-1"></i> Editar
                                        </a>

                                        @can('delete', $entrenamiento)
                                            <button onclick="openModal('entrenamiento', {{ $entrenamiento->id }})"
                                                    class="text-red-500 hover:text-red-600 transition duration-200 flex items-center"
                                                    title="Eliminar entrenamiento" aria-label="Eliminar">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    {{-- Confirmation Deletion Modal (reutilizado de tu ejemplo) --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 p-4 hidden"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
        <div class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-lg border border-gray-700 animate-scale-in">
            <h2 class="text-3xl font-bold text-white mb-4">Confirmar Eliminación</h2>
            <p class="text-gray-300 mb-6 text-lg">¿Estás seguro de que quieres eliminar este entrenamiento? Esta acción es
                permanente y no se puede deshacer.</p>
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button onclick="closeModal()"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75">
                    Cancelar
                </button>
                <form id="deleteForm" action="" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                        Sí, Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        {{-- Carga Feather Icons si no lo haces globalmente --}}
        <script src="https://unpkg.com/feather-icons"></script>
        <script>
            feather.replace(); // Inicializa Feather Icons

            function openModal(tipo, id) {
                document.getElementById('deleteModal').classList.remove('hidden');
                let baseUrl = `/admin-entrenador/entrenamientos/${id}`; // Ruta para entrenamientos
                document.getElementById('deleteForm').action = baseUrl;
            }

            function closeModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        </script>
        {{-- Incluye las animaciones CSS si no están en tu CSS principal --}}
        <style>
            @keyframes fadeInDown {
                from { opacity: 0; transform: translateY(-20px); }
                to { opacity: 1; transform: translateY(0); }
            }
            .animate-fade-in-down { animation: fadeInDown 0.5s ease-out forwards; }

            @keyframes scaleIn {
                from { opacity: 0; transform: scale(0.9); }
                to { opacity: 1; transform: scale(1); }
            }
            .animate-scale-in { animation: scaleIn 0.3s ease-out forwards; }

            /* Para el hover de la tabla, similar a bg-gray-750 de tu ejemplo */
            .hover\:bg-gray-750:hover {
                background-color: #3b4252; /* Un gris ligeramente más claro que gray-800 */
            }
        </style>
    @endpush
</x-app-layout>