<x-app-layout>
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Editar Entrenamiento</h1>

        <!-- Formulario para editar entrenamiento -->
        <form action="{{ route('admin-entrenador.entrenamientos.update', $entrenamiento->id_entrenamiento) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
            @csrf
            @method('PUT')

            <!-- Nombre del entrenamiento -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" value="{{ $entrenamiento->nombre }}" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Tipo de entrenamiento -->
            <div class="mb-4">
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo</label>
                <input type="text" name="tipo" value="{{ $entrenamiento->tipo }}" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Duración del entrenamiento -->
            <div class="mb-4">
                <label for="duracion" class="block text-sm font-medium text-gray-700">Duración (minutos)</label>
                <input type="number" name="duracion" value="{{ $entrenamiento->duracion }}" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Fecha del entrenamiento -->
            <div class="mb-6">
                <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" value="{{ $entrenamiento->fecha }}" required class="mt-2 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <!-- Botón de actualización -->
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow-md hover:bg-blue-700 transition duration-300">Actualizar</button>
            </div>
        </form>
    </div>
</x-app-layout>
