<x-app-layout>
    {{-- Contenedor principal de la página con fondo oscuro y padding --}}
    <div class="py-8 md:py-12 bg-gray-900 min-h-screen">
        <div class="max-w-xl md:max-w-4xl lg:max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Encabezado de la Página: Título y Botones de Acción --}}
            <header class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-4xl font-extrabold text-white text-center sm:text-left">
                    Gestión de Entrenamientos
                </h1>
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 w-full sm:w-auto">
                    {{-- Botón para Volver al Dashboard --}}
                    <a href="{{ route('admin-entrenador.dashboard') }}"
                        class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75">
                        <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i> Volver
                    </a>
                    {{-- Botón de Creación --}}
                    <a href="{{ route('admin-entrenador.entrenamientos.create') }}"
                        class="inline-flex items-center justify-center bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                        <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i> Crear Entrenamiento
                    </a>
                </div>
            </header>

            {{-- Mensajes de Sesión (Éxito) --}}
            @if (session('success'))
                <div class="bg-green-700 border-l-4 border-green-500 text-green-100 p-4 rounded-md mb-6 shadow-md"
                    role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0">
                    <p class="font-bold mb-1">¡Éxito!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- Sección de Filtros y Búsqueda --}}
            <div class="bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6 mb-8">
                <h2 class="text-2xl font-bold text-white mb-5 border-b border-gray-700 pb-3 flex items-center">
                    <i data-feather="filter" class="w-6 h-6 mr-3 text-red-500"></i> Buscar y Filtrar Entrenamientos
                </h2>
                <form method="GET" action="{{ route('admin-entrenador.entrenamientos.index') }}" class="space-y-6">
                    {{-- Campo de búsqueda por título/descripción --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-300 mb-2">Buscar por Título o
                            Descripción</label>
                        <div class="relative">
                            <input type="text" name="search" id="search"
                                placeholder="Escribe para buscar..." value="{{ request('search') }}"
                                class="w-full pl-10 pr-4 py-2 bg-gray-700 border-gray-600 text-white placeholder-gray-400 focus:border-red-600 focus:ring-red-600 rounded-lg transition duration-200"
                                aria-label="Buscar entrenamiento por título o descripción">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-feather="search" class="h-5 w-5 text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Filtro por Nivel --}}
                    <div>
                        <label for="nivel" class="block text-sm font-medium text-gray-300 mb-2">Filtrar por Nivel de
                            Dificultad</label>
                        <div class="relative">
                            <select name="nivel" id="nivel"
                                class="w-full pl-10 pr-4 py-2 bg-gray-700 border-gray-600 text-white focus:border-red-600 focus:ring-red-600 rounded-lg appearance-none transition duration-200"
                                aria-label="Seleccionar nivel de dificultad">
                                <option value="">Todos los Niveles</option>
                                <option value="bajo" {{ request('nivel') == 'bajo' ? 'selected' : '' }}>Bajo</option>
                                <option value="medio" {{ request('nivel') == 'medio' ? 'selected' : '' }}>Medio</option>
                                <option value="alto" {{ request('nivel') == 'alto' ? 'selected' : '' }}>Alto</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-feather="trending-up" class="h-5 w-5 text-gray-400"></i>
                            </div>
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                <i data-feather="chevron-down" class="h-4 w-4"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de acción para el filtro --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-75 flex items-center justify-center">
                            <i data-feather="check-circle" class="w-5 h-5 mr-2"></i> Aplicar Filtros
                        </button>
                        <a href="{{ route('admin-entrenador.entrenamientos.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-2.5 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 flex items-center justify-center">
                            <i data-feather="rotate-ccw" class="w-5 h-5 mr-2"></i> Limpiar Filtros
                        </a>
                    </div>
                </form>
            </div>

            {{-- Contenedor principal de la tabla --}}
            <div class="bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6">
                @if ($entrenamientos->isEmpty())
                    {{-- Mensaje para cuando no hay entrenamientos --}}
                    <div class="bg-gray-700 border-l-4 border-red-600 text-gray-100 p-4 rounded-md" role="alert">
                        <p class="font-bold mb-1">¡Vaya, no hay entrenamientos que coincidan!</p>
                        <p>No se encontraron entrenamientos con los criterios de búsqueda y filtro aplicados. Prueba
                            ajustando los filtros o creando uno nuevo.</p>
                    </div>
                @else
                    {{-- Tabla de entrenamientos --}}
                    <div class="overflow-x-auto rounded-lg shadow-inner border border-gray-700">
                        <table class="min-w-full table-auto divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Título
                                    </th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Nivel
                                    </th>
                                    <th
                                        class="px-5 py-3 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Usuarios Guardados
                                    </th>
                                    <th
                                        class="px-5 py-3 text-center text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($entrenamientos as $entrenamiento)
                                    <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                                        <td class="px-5 py-4 text-white font-medium">
                                            {{ $entrenamiento->titulo }}
                                        </td>
                                        <td class="px-5 py-4 capitalize">
                                            {{-- Insignia de Nivel con colores --}}
                                            @php
                                                $nivelClasses = [
                                                    'bajo' => 'bg-blue-700 text-blue-100',
                                                    'medio' => 'bg-yellow-700 text-yellow-100',
                                                    'alto' => 'bg-red-700 text-red-100',
                                                ];
                                                $currentNivelClass = $nivelClasses[$entrenamiento->nivel] ?? 'bg-gray-600 text-gray-100';
                                            @endphp
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $currentNivelClass }}">
                                                {{ $entrenamiento->nivel }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-center">
                                            <a href="{{ route('admin-entrenador.entrenamientos.usuarios', $entrenamiento->id) }}"
                                                class="text-blue-400 hover:text-blue-500 underline font-medium"
                                                title="Ver usuarios que guardaron este entrenamiento"
                                                aria-label="Ver usuarios de {{ $entrenamiento->titulo }}">
                                                {{ $entrenamiento->usuariosGuardaron->count() }}
                                            </a>
                                        </td>
                                        <td class="px-5 py-4 flex items-center justify-center space-x-3">
                                            {{-- Botón de Editar --}}
                                            <a href="{{ route('admin-entrenador.entrenamientos.edit', $entrenamiento->id) }}"
                                                class="text-blue-400 hover:text-blue-500 transition duration-200 flex items-center"
                                                title="Editar entrenamiento"
                                                aria-label="Editar {{ $entrenamiento->titulo }}">
                                                <i data-feather="edit" class="w-4 h-4 mr-1"></i> Editar
                                            </a>

                                            {{-- Botón de Eliminar --}}
                                            <button
                                                x-data="{}"
                                                @click="$dispatch('open-delete-modal', { id: {{ $entrenamiento->id }} })"
                                                class="text-red-500 hover:text-red-600 transition duration-200 flex items-center"
                                                title="Eliminar entrenamiento"
                                                aria-label="Eliminar {{ $entrenamiento->titulo }}">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Confirmation Deletion Modal (Utiliza x-show/x-transition para Alpine.js) --}}
    {{-- He modificado el modal para que use un evento de Alpine.js --}}
    <div x-data="{ show: false, deleteUrl: '' }"
        @open-delete-modal.window="show = true; deleteUrl = '/admin-entrenador/entrenamientos/' + $event.detail.id"
        x-show="show"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
        class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 p-4"
        style="display: none;"> {{-- Añadido display: none para evitar parpadeo inicial si no se usa x-cloak --}}
        <div @click.away="show = false" class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-lg border border-gray-700 animate-scale-in">
            <h2 class="text-3xl font-bold text-white mb-4">Confirmar Eliminación</h2>
            <p class="text-gray-300 mb-6 text-lg">¿Estás seguro de que quieres eliminar este entrenamiento? Esta acción
                es permanente y no se puede deshacer.</p>
            <div class="flex flex-col sm:flex-row justify-end gap-3">
                <button @click="show = false"
                    class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75">
                    Cancelar
                </button>
                <form :action="deleteUrl" method="POST" class="w-full sm:w-auto">
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
        {{-- Asegúrate de que Alpine.js se cargue ANTES de este script --}}
        {{-- Si usas Laravel Mix/Vite, asegúrate de que el script de Alpine.js esté en tu app.js --}}
        {{-- Si no, puedes añadirlo aquí si es solo para esta vista:
             <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
        --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Inicializar Feather Icons
                if (window.feather) {
                    feather.replace();
                }

                // Cierre del modal con la tecla Escape
                document.addEventListener('keydown', function(event) {
                    const deleteModal = document.querySelector('[x-data="{ show: false, deleteUrl: \'\' }"]');
                    if (deleteModal && event.key === 'Escape' && deleteModal.__x.$data.show) {
                        deleteModal.__x.$data.show = false;
                    }
                });
            });
        </script>
        <style>
            /* Animaciones y estilos custom si no están en tu CSS principal */
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

            /* Para el hover de la tabla, ajustado para ser más sutil y consistente con gray-800 -> gray-700 */
            .hover\:bg-gray-700:hover {
                background-color: #374151; /* gray-700 */
            }
        </style>
    @endpush
</x-app-layout>