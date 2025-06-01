<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        @if (session('success'))
            <div class="bg-green-700 border border-green-800 text-white px-4 py-3 rounded-lg relative mb-6 shadow-md animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg relative mb-6 shadow-md animate-fade-in">
                {{ session('error') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold text-white mb-6">Listado de Clases</h1>

        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <a href="{{ route('admin-entrenador.clases.create') }}"
                class="inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition duration-200 transform hover:scale-105 min-w-[180px]">
                <i data-feather="plus-circle" class="w-5 h-5 mr-2"></i> Crear Clase
            </a>

            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="inline-flex items-center justify-center bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition duration-200 transform hover:scale-105 min-w-[180px]">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-800 shadow-lg rounded-xl p-4 border border-gray-700">
            <table class="min-w-full table-auto divide-y divide-gray-700">
                <thead>
                    <tr class="bg-gray-700">
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Clase</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Entrenador</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Fecha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($clases as $clase)
                        <tr class="hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-4 py-3 text-white">{{ $clase->nombre }}</td>
                            <td class="px-4 py-3 text-gray-300">
                                {{-- Verificar si el entrenador está asignado antes de acceder a su nombre --}}
                                {{ $clase->entrenador ? $clase->entrenador->name : 'No asignado' }}
                            </td>
                            <td class="px-4 py-3 text-gray-300">{{ $clase->fecha }}</td>
                            <td class="px-4 py-3 flex items-center space-x-4">
                                <a href="{{ route('admin-entrenador.clases.edit', $clase) }}"
                                    class="text-yellow-400 hover:text-yellow-500 font-medium transition duration-200">Editar</a>
                                <button onclick="openModal({{ $clase->id_clase }})" class="text-red-500 hover:text-red-600 font-medium transition duration-200">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center text-gray-400">No hay clases registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-70 flex justify-center items-center z-50 hidden p-4">
        <div class="bg-gray-800 p-8 rounded-xl shadow-xl w-full max-w-sm border border-gray-700 animate-scale-in">
            <h2 class="text-2xl font-bold text-white mb-4">¿Estás seguro?</h2>
            <p class="text-gray-300 mb-6">Esta acción eliminará la clase permanentemente y no se puede deshacer.</p>
            <div class="flex justify-end gap-3">
                <button onclick="closeModal()" class="bg-gray-600 hover:bg-gray-700 text-white font-bold px-5 py-2 rounded-lg shadow-md transition duration-200">Cancelar</button>
                <form id="deleteForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-5 py-2 rounded-lg shadow-md transition duration-200">Eliminar</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Función para abrir el modal
            function openModal(claseId) {
                document.getElementById('deleteModal').classList.remove('hidden');
                document.getElementById('deleteForm').action = '/admin-entrenador/clases/' + claseId; // Asegúrate de que esta ruta sea correcta
            }

            // Función para cerrar el modal
            function closeModal() {
                document.getElementById('deleteModal').classList.add('hidden');
            }
        </script>
    @endpush
</x-app-layout>
