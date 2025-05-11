<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Crear Entrenamiento</h1>

        <!-- Formulario para crear entrenamiento -->
        <form action="{{ route('admin-entrenador.entrenamientos.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf

            <!-- Campo de nombre -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre del entrenamiento" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Campo de tipo -->
            <div class="mb-4">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <input type="text" name="tipo" id="tipo" placeholder="Tipo de entrenamiento" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Campo de duración -->
            <div class="mb-4">
                <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (min)</label>
                <input type="number" name="duracion" id="duracion" placeholder="Duración en minutos" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Campo de fecha -->
            <div class="mb-6">
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" id="fecha" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500">
            </div>

            <!-- Botón de submit -->
            <button type="submit" class="w-full bg-green-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-600 transition duration-300">Guardar</button>
        </form>
    </div>
</x-app-layout>
