<x-app-layout>
    <h1 class="text-xl font-bold mb-4">Asignar Usuario a Entrenamiento: {{ $entrenamiento->nombre }}</h1>
    <form action="{{ route('admin-entrenador.entrenamientos.guardarAsignacion', $entrenamiento->id_entrenamiento) }}" method="POST">
        @csrf
        <select name="usuario_id" class="block mb-4">
            @foreach($usuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
            @endforeach
        </select>
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Asignar</button>
    </form>
</x-app-layout>