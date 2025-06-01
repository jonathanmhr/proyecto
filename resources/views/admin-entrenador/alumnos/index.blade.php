<x-app-layout>
    {{-- El div principal del contenido, asumiendo que el x-app-layout ya provee un fondo oscuro general --}}
    {{-- Si no, puedes añadir 'bg-gray-900 min-h-screen' aquí o en el layout --}}
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-white">Gestión de Alumnos</h2>
            <a href="{{ route('admin-entrenador.dashboard') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-700 text-white rounded-lg shadow-lg border border-green-800 animate-fade-in">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-700">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-300 uppercase tracking-wider">Clases</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-300 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($alumnos as $alumno)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-white">{{ $alumno->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $alumno->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                {{ $alumno->clases->count() }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="{{ route('admin-entrenador.entrenadores.edit', $alumno->id) }}"
                                   class="inline-flex items-center px-3 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg shadow-md transition duration-200">
                                    <i data-feather="edit" class="w-4 h-4 mr-1"></i> Gestionar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">No hay alumnos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
