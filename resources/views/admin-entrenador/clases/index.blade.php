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

        <h1 class="text-4xl font-extrabold mb-8 text-white text-center md:text-left">Gestión de Clases</h1>

        {{-- Action Buttons --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full md:w-auto">
                <a href="{{ route('admin-entrenador.clases.create') }}"
                    class="flex items-center justify-center bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                    <i data-feather="users" class="w-5 h-5 mr-2"></i> Crear Clase Grupal
                </a>
                <a href="{{ route('admin-entrenador.clases-individuales.create') }}"
                    class="flex items-center justify-center bg-red-700 hover:bg-red-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                    <i data-feather="user" class="w-5 h-5 mr-2"></i> Crear Clase Individual
                </a>
            </div>
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="flex items-center justify-center bg-gray-700 hover:bg-gray-800 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 w-full md:w-auto">
                <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i> Volver al Dashboard
            </a>
        </div>

        {{-- Tabs for Group and Individual Classes --}}
        <div x-data="{ tab: 'grupal' }" class="mb-6 bg-gray-800 rounded-xl shadow-xl border border-gray-700 p-6">
            <nav class="flex border-b border-gray-700 mb-6">
                <button @click="tab = 'grupal'"
                    :class="tab === 'grupal' ? 'border-red-600 text-red-600 font-bold' :
                        'text-gray-400 hover:text-red-500 border-transparent'"
                    class="py-3 px-8 border-b-2 transition duration-300 ease-in-out focus:outline-none text-lg"
                    aria-controls="group-classes-panel" :aria-selected="tab === 'grupal'">
                    Clases Grupales
                </button>
                <button @click="tab = 'individual'"
                    :class="tab === 'individual' ? 'border-red-600 text-red-600 font-bold' :
                        'text-gray-400 hover:text-red-500 border-transparent'"
                    class="py-3 px-8 border-b-2 transition duration-300 ease-in-out focus:outline-none text-lg"
                    aria-controls="individual-classes-panel" :aria-selected="tab === 'individual'">
                    Clases Individuales
                </button>
            </nav>

            {{-- Group Classes Table Content --}}
            <div x-show="tab === 'grupal'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0" id="group-classes-panel" role="tabpanel">
                <div class="overflow-x-auto">
                    @if ($clasesGrupales->isNotEmpty())
                        <table class="min-w-full table-auto divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tl-lg">
                                        Clase</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Entrenador</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Fecha</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tr-lg">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($clasesGrupales as $clase)
                                    <tr class="hover:bg-gray-750 transition duration-150 ease-in-out">
                                        <td class="px-5 py-4 text-white font-medium">{{ $clase->nombre }}</td>
                                        <td class="px-5 py-4 text-gray-300">
                                            {{ $clase->entrenador?->name ?? 'No asignado' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-300">
                                            {{ Carbon\Carbon::parse($clase->fecha)->format('d/m/Y H:i') }}</td>
                                        <td class="px-5 py-4 flex items-center space-x-4">
                                            <a href="{{ route('admin-entrenador.clases.edit', $clase) }}"
                                                class="text-blue-400 hover:text-blue-500 font-medium transition duration-200 flex items-center"
                                                title="Editar clase grupal">
                                                <i data-feather="edit" class="w-4 h-4 mr-1"></i> Editar
                                            </a>
                                            <button onclick="openModal('grupal', {{ $clase->id_clase }})"
                                                class="text-red-500 hover:text-red-600 font-medium transition duration-200 flex items-center"
                                                title="Eliminar clase grupal">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="px-5 py-6 text-center text-gray-400 text-lg">No hay clases grupales registradas en
                            este momento.</p>
                    @endif
                </div>
            </div>

            {{-- Individual Classes Table Content --}}
            <div x-show="tab === 'individual'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0" style="display: none;"
                id="individual-classes-panel" role="tabpanel">
                <div class="overflow-x-auto">
                    @if ($clasesIndividuales->isNotEmpty())
                        <table class="min-w-full table-auto divide-y divide-gray-700">
                            <thead>
                                <tr class="bg-gray-700">
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tl-lg">
                                        Clase</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Entrenador</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Fecha</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider">
                                        Cliente</th>
                                    <th
                                        class="px-5 py-3 text-left text-sm font-semibold text-gray-300 uppercase tracking-wider rounded-tr-lg">
                                        Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                @foreach ($clasesIndividuales as $clase)
                                    <tr class="hover:bg-gray-750 transition duration-150 ease-in-out">
                                        <td class="px-5 py-4 text-white font-medium">{{ $clase->titulo}}</td>
                                        <td class="px-5 py-4 text-gray-300">
                                            {{ $clase->entrenador?->name ?? 'No asignado' }}
                                        </td>
                                        <td class="px-5 py-4 text-gray-300">
                                            {{ \Carbon\Carbon::parse($clase->fecha)->format('d/m/Y H:i') }}</td>
                                        <td class="px-5 py-4 text-gray-300">
                                            {{ $clase->usuario?->name ?? 'No asignado' }}
                                        </td>
                                        <td class="px-5 py-4 flex items-center space-x-4">
                                            <a href="{{ route('admin-entrenador.clases-individuales.edit', $clase->id) }}"
                                                class="text-blue-400 hover:text-blue-500 font-medium transition duration-200 flex items-center"
                                                title="Editar clase individual">
                                                <i data-feather="edit" class="w-4 h-4 mr-1"></i> Editar
                                            </a>
                                            <button onclick="openModal('individual', {{ $clase->id_clase }})"
                                                class="text-red-500 hover:text-red-600 font-medium transition duration-200 flex items-center"
                                                title="Eliminar clase individual">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="px-5 py-6 text-center text-gray-400 text-lg">No hay clases individuales registradas
                            en este momento.</p>
                    @endif
                </div>
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
            <p class="text-gray-300 mb-6 text-lg">¿Estás seguro de que quieres eliminar esta clase? Esta acción es
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
            function openModal(tipo, claseId) {
                document.getElementById('deleteModal').classList.remove('hidden');

                let baseUrl = tipo === 'grupal' ?
                    `/admin-entrenador/clases/${claseId}` :
                    `/admin-entrenador/clases-individuales/${claseId}`;

                document.getElementById('deleteForm').action = baseUrl;
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