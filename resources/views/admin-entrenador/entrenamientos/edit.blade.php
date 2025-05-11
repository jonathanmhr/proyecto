<x-app-layout>
    <h1 class="text-xl font-bold mb-4">Editar Entrenamiento</h1>
    <form action="{{ route('admin-entrenador.entrenamientos.update', $entrenamiento->id_entrenamiento) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="nombre" value="{{ $entrenamiento->nombre }}" required class="block mb-2">
        <input type="text" name="tipo" value="{{ $entrenamiento->tipo }}" required class="block mb-2">
        <input type="number" name="duracion" value="{{ $entrenamiento->duracion }}" required class="block mb-2">
        <input type="date" name="fecha" value="{{ $entrenamiento->fecha }}" required class="block mb-4">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
    </form>
</x-app-layout>