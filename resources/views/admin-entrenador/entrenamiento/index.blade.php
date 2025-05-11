<x-app-layout>
    <h1 class="text-xl font-bold mb-4">Lista de Entrenamientos</h1>
    <a href="{{ route('entrenamientos.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Nuevo</a>
    <table class="mt-4 w-full">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Duración</th>
                <th>Fecha</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entrenamientos as $entrenamiento)
                <tr>
                    <td>{{ $entrenamiento->nombre }}</td>
                    <td>{{ $entrenamiento->tipo }}</td>
                    <td>{{ $entrenamiento->duracion }} min</td>
                    <td>{{ $entrenamiento->fecha }}</td>
                    <td>
                        <a href="{{ route('entrenamientos.show', $entrenamiento->id_entrenamiento) }}" class="text-green-600">Ver</a>
                        |
                        <a href="{{ route('entrenamientos.edit', $entrenamiento->id_entrenamiento) }}" class="text-blue-600">Editar</a>
                        |
                        <form action="{{ route('entrenamientos.destroy', $entrenamiento->id_entrenamiento) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
