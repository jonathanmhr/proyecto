<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-white">
                Editar Clase: <span class="text-red-500">{{ $clase->nombre }}</span>
            </h1>
            <a href="{{ route('entrenador.clases.index') }}" {{-- Ruta corregida para volver al listado --}}
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver
            </a>
        </div>

        <form method="POST" action="{{ route('entrenador.clases.update', $clase->id_clase) }}">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-gray-800 shadow-lg rounded-xl p-6 space-y-6 border border-gray-700">

                <div>
                    <label for="nombre" class="block text-white font-semibold mb-2">Nombre de la clase</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $clase->nombre) }}" 
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                </div>

                <div>
                    <label for="descripcion" class="block text-white font-semibold mb-2">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="4" 
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200">{{ old('descripcion', $clase->descripcion) }}</textarea>
                </div>

                <div>
                    <label for="ubicacion" class="block text-white font-semibold mb-2">Ubicación</label>
                    <input type="text" id="ubicacion" name="ubicacion" value="{{ old('ubicacion', $clase->ubicacion) }}" 
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200">
                </div>

                <div>
                    <label for="cupos_maximos" class="block text-white font-semibold mb-2">Cupos disponibles</label>
                    <input type="number" id="cupos_maximos" name="cupos_maximos" value="{{ old('cupos_maximos', $clase->cupos_maximos) }}" 
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                </div>

                <div>
                    <label for="nivel" class="block text-white font-semibold mb-2">Nivel</label>
                    <select id="nivel" name="nivel" 
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="principiante" {{ old('nivel', $clase->nivel) == 'principiante' ? 'selected' : '' }}>Principiante</option>
                        <option value="intermedio" {{ old('nivel', $clase->nivel) == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                        <option value="avanzado" {{ old('nivel', $clase->nivel) == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>

                <div class="text-center mt-8">
                    <button type="submit" 
                        class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 shadow-md transition duration-200 transform hover:scale-105">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-app-layout>
