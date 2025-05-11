<x-app-layout>
    <h1 class="text-xl font-bold mb-4">Usuarios en Entrenamiento: {{ $entrenamiento->nombre }}</h1>
    <a href="{{ route('admin-entrenador.entrenamientos.asignar', $entrenamiento->id_entrenamiento) }}" class="bg-green-500 text-white px-4 py-2 rounded">Asignar Usuario</a>
    <ul class="mt-4">
        @foreach($usuarios as $usuario)
            <li class="mb-2">
                {{ $usuario->name }} - {{ $usuario->email }}
                <form action="{{ route('admin-entrenador.entrenamientos.quitar', [$entrenamiento->id_entrenamiento, $usuario->id]) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 ml-2">Quitar</button>
                </form>
            </li>
        @endforeach
    </ul>
</x-app-layout>