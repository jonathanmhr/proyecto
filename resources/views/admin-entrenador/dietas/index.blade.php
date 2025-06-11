<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">

        {{-- Session Messages --}}
        @if (session('success'))
            <div class="bg-green-600 border border-green-700 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in-down"
                role="alert">
                <div class="flex items-center">
                    <i data-feather="check-circle" class="w-5 h-5 mr-3"></i>
                    <div>
                        {{ session('success') }}
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-600 border border-red-700 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in-down"
                role="alert">
                <div class="flex items-center">
                    <i data-feather="x-circle" class="w-5 h-5 mr-3"></i>
                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif

        <h1 class="text-4xl font-extrabold mb-8 text-white text-center md:text-left">Gestión de Dietas</h1>

        {{-- Action Buttons --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full md:w-auto">
                <a href="{{ route('admin-entrenador.dietas.create') }}"
                    class="flex items-center justify-center bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                    <i data-feather="plus" class="w-5 h-5 mr-2"></i> Crear Nueva Dieta
                </a>
            </div>
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="flex items-center justify-center bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 w-full md:w-auto">
                <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i> Volver al Dashboard
            </a>
        </div>

        {{-- Dietas Table Content --}}
        <div class="mb-6 bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6">
            <div class="overflow-x-auto">
                @if ($dietas->isNotEmpty())
                    <table class="min-w-full table-auto divide-y divide-gray-700">
                        <thead>
                            <tr class="bg-gray-700">
                                <th
                                    class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tl-lg">
                                    Imagen</th>
                                <th
                                    class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                    Nombre</th>
                                <th
                                    class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                    Calorías</th>
                                <th
                                    class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                    Usuarios Asignados</th>
                                <th
                                    class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tr-lg">
                                    Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach ($dietas as $dieta)
                                <tr class="hover:bg-gray-750 transition duration-150 ease-in-out">
                                    <td class="px-5 py-4">
                                        @if ($dieta->image_url)
                                            <img src="{{ url($dieta->image_url) }}" alt="{{ $dieta->nombre }}"
                                                class="h-10 w-10 rounded-full object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-full bg-gray-700 flex items-center justify-center">
                                                <i data-feather="image" class="w-4 h-4 text-gray-300"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-white font-medium">{{ $dieta->nombre }}</td>
                                    <td class="px-5 py-4 text-gray-300">{{ $dieta->calorias_diarias }} kcal</td>
                                    <td class="px-5 py-4 text-gray-300">{{ $dieta->users_count }}</td>
                                    <td class="px-5 py-4 flex items-center space-x-4">
                                        <a href="{{ route('admin-entrenador.dietas.edit', $dieta) }}"
                                            class="text-blue-400 hover:text-blue-500 font-medium transition duration-200 flex items-center"
                                            title="Editar dieta">
                                            <i data-feather="edit" class="w-4 h-4 mr-1"></i> Editar
                                        </a>
                                        <button onclick="openModal({{ $dieta->id }})"
                                            class="text-red-500 hover:text-red-600 font-medium transition duration-200 flex items-center"
                                            title="Eliminar dieta">
                                            <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="px-5 py-6 text-center text-gray-400 text-lg">No hay dietas registradas en este momento.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Confirmation Deletion Modal --}}
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 p-4 hidden"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
        x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
        <div class="bg-gray-800 p-8 rounded-xl shadow-2xl w-full max-w-lg border border-gray-700 animate-scale-in">
            <h2 class="text-3xl font-bold text-white mb-4">Confirmar Eliminación</h2>
            <p class="text-gray-300 mb-6 text-lg">¿Estás seguro de que quieres eliminar esta dieta? Esta acción es
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
        <script>
            function openModal(dietaId) {
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteForm').action = `/admin-entrenador/dietas/${dietaId}`;
            }

            function closeModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }

            // Optional: Close modal on ESC key press
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        </script>
        {{-- Custom Tailwind CSS animations (you can add them to your main CSS file) --}}
        <style>
            @keyframes fadeInDown {
                from {
                    opacity: 0;
                    transform: translateY(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .animate-fade-in-down {
                animation: fadeInDown 0.5s ease-out forwards;
            }

            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.9);
                }

                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            .animate-scale-in {
                animation: scaleIn 0.3s ease-out forwards;
            }

            /* Additional styles for table row hover */
            .hover\:bg-gray-750:hover {
                background-color: #3b4252;
                /* A slightly lighter gray for hover */
            }
        </style>
    @endpush
</x-app-layout>