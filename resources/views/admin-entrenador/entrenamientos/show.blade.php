<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6">
            Usuarios en Entrenamiento: {{ $entrenamiento->nombre }}
        </h1>

        <a href="{{ route('admin-entrenador.entrenamientos.asignar', $entrenamiento->id_entrenamiento) }}"
           class="inline-block bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded mb-6">
            Asignar Usuario
        </a>

        <ul class="space-y-4">
            @forelse($usuarios ?? [] as $usuario)
                <li class="bg-white shadow-sm rounded-lg px-4 py-3 flex items-center justify-between">
                    <div>
                        <p class="font-medium text-gray-800">{{ $usuario->name }}</p>
                        <p class="text-sm text-gray-500">{{ $usuario->email }}</p>
                    </div>

                    <form action="{{ route('admin-entrenador.entrenamientos.quitar', [$entrenamiento->id_entrenamiento, $usuario->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                            Quitar
                        </button>
                    </form>
                </li>
            @empty
                <li class="text-gray-600">No hay usuarios asignados a este entrenamiento.</li>
            @endforelse
        </ul>
    </div>
</x-app-layout>
