<x-app-layout>
    <h1 class="text-xl font-bold mb-4">Crear Entrenamiento</h1>
    <form action="{{ route('admin-entrenador.entrenamientos.store') }}" method="POST">
        @csrf
        <input type="text" name="nombre" placeholder="Nombre" required class="block mb-2">
        <input type="text" name="tipo" placeholder="Tipo" required class="block mb-2">
        <input type="number" name="duracion" placeholder="Duración (min)" required class="block mb-2">
        <input type="date" name="fecha" required class="block mb-4">
        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Guardar</button>
    </form>
</x-app-layout>