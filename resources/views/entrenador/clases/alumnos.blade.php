<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">¡Alumnos Inscritos en <span class="text-red-500">{{ $clase->nombre }}</span>!</h1>
            <a href="{{ route('admin-entrenador.clases.index') }}" {{-- Assuming this route is correct for returning to the main class list --}}
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-700">
            <h2 class="text-xl font-bold text-white mb-4">Lista de Alumnos</h2>

            @forelse ($alumnos as $alumno)
                <div class="border-b border-gray-700 pb-3 mb-3 last:border-b-0">
                    <div class="text-white font-medium text-lg">{{ $alumno->usuario->name }}</div>
                    <div class="text-sm text-gray-300">{{ $alumno->usuario->email }}</div>
                    <div class="flex space-x-2 mt-3">
                        <form action="{{ route('admin-entrenador.clases.quitarUsuario', ['clase' => $clase->id_clase, 'userId' => $alumno->usuario->id]) }}" method="POST"
                            onsubmit="return confirm('¿Estás seguro de quitar a {{ $alumno->usuario->name }} de esta clase? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600 font-medium transition duration-200">
                                Quitar Alumno
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-gray-400 text-center py-4">No hay alumnos inscritos en esta clase.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
