<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alumnos de la clase: ') }} {{ $clase->nombre }}
        </h2>
    </x-slot>

    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-6">
            👋 ¡Alumnos Inscritos!
        </h1>

        <div class="bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-xl font-semibold text-gray-700 mb-4">Alumnos Inscritos</h2>

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
