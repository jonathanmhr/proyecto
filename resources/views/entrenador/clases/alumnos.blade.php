<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <!-- Título y botón "Volver" en una fila -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">¡Alumnos Inscritos!</h1>
            <a href="{{ route('entrenador.clases.index') }}" 
                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Alumnos Inscritos en la clase: {{ $clase->nombre }}</h2>

            @foreach ($alumnos as $alumno)
                <div class="border-b border-gray-300 pb-2 mb-2">
                    <div class="text-gray-800 font-medium">{{ $alumno->usuario->name }}</div>
                    <div class="text-sm text-gray-600">{{ $alumno->usuario->email }}</div>
                    <div class="flex space-x-2 mt-2">
                        <form action="{{ route('entrenador.clases.quitarUsuario', ['clase' => $clase->id_clase, 'userId' => $alumno->usuario->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">Eliminar Alumno</button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if($alumnos->isEmpty())
                <p class="text-gray-600">No hay alumnos inscritos en esta clase.</p>
            @endif
        </div>
    </div>
</x-app-layout>
