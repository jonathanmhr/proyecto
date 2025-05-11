<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Usuarios en Entrenamiento: {{ $entrenamiento->nombre }}</h1>

        <!-- Botón para asignar un nuevo usuario -->
        <a href="{{ route('admin-entrenador.entrenamientos.asignar', $entrenamiento->id_entrenamiento) }}" class="bg-green-500 text-white px-6 py-2 rounded-lg shadow-md hover:bg-green-600 transition duration-300">Asignar Usuario</a>

        <!-- Lista de usuarios asignados -->
        <ul class="mt-6 space-y-4">
            @foreach($usuarios as $usuario)
                <li class="flex justify-between items-center bg-gray-100 p-4 rounded-lg shadow-md">
                    <div class="flex flex-col">
                        <span class="font-semibold text-gray-800">{{ $usuario->name }}</span>
                        <span class="text-sm text-gray-600">{{ $usuario->email }}</span>
                    </div>

                    <!-- Formulario para quitar usuario -->
                    <form action="{{ route('admin-entrenador.entrenamientos.quitar', [$entrenamiento->id_entrenamiento, $usuario->id]) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 transition duration-300">Quitar</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</x-app-layout>
