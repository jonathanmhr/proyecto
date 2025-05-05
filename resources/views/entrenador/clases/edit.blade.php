<x-app-layout>
    <!-- Título con el formato adecuado y el botón "Volver" -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Editar Clase</h1>
        <a href="{{ route('entrenador.clases.index') }}" 
            class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 hover:bg-blue-200 font-semibold rounded-lg transition">
            <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
        </a>
    </div>

    <div class="container mx-auto px-4 py-6">
        <form method="POST" action="{{ route('entrenador.clases.update', $clase->id_clase) }}">
            @csrf
            @method('PUT')

            <!-- Nombre de la clase -->
            <div class="mb-4">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre de la clase</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $clase->nombre) }}" 
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Descripción -->
            <div class="mb-4">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" 
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('descripcion', $clase->descripcion) }}</textarea>
            </div>

            <!-- Ubicación -->
            <div class="mb-4">
                <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $clase->ubicacion) }}" 
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Cupos disponibles -->
            <div class="mb-4">
                <label for="cupos_maximos" class="block text-sm font-medium text-gray-700">Cupos disponibles</label>
                <input type="number" id="cupos_maximos" name="cupos_maximos" value="{{ old('cupos_maximos', $clase->cupos_maximos) }}" 
                    class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Nivel -->
            <div class="mb-4">
                <label for="nivel" class="block text-sm font-medium text-gray-700">Nivel</label>
                <select id="nivel" name="nivel" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="principiante" {{ $clase->nivel == 'principiante' ? 'selected' : '' }}>Principiante</option>
                    <option value="intermedio" {{ $clase->nivel == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                    <option value="avanzado" {{ $clase->nivel == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
                </select>
            </div>

            <!-- Botón de guardar cambios -->
            <div class="text-center">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-700">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
