<x-app-layout>
    <div class="container mx-auto px-4 py-6">

        <h1 class="text-2xl font-bold mb-6">Editar Clase: {{ $clase->nombre }}</h1>
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('admin-entrenador.dashboard') }}"
                class="bg-green-100 hover:bg-green-200 text-green-700 font-semibold py-3 px-4 rounded-xl flex items-center gap-2 transition w-[160px] justify-center">
                <i data-feather="arrow-left" class="w-4 h-4"></i> Volver
            </a>
        </div>
        <form action="{{ route('admin-entrenador.clases.update', $clase) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="bg-white shadow rounded-xl p-6">

                <!-- Nombre de la clase -->
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre de la Clase</label>
                    <input type="text" name="nombre" id="nombre" value="{{ $clase->nombre }}"
                        class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Selección de Entrenador -->
                <div class="mb-4">
                    <label for="entrenador_id" class="block text-gray-700">Entrenador</label>
                    <select name="entrenador_id" id="entrenador_id" class="w-full p-3 border border-gray-300 rounded"
                        required>
                        <option value="">Seleccionar Entrenador</option>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}"
                                {{ $clase->entrenador_id == $entrenador->id ? 'selected' : '' }}>
                                {{ $entrenador->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="w-full p-3 border border-gray-300 rounded">{{ $clase->descripcion }}</textarea>
                </div>

                <!-- Fecha inicio -->
                <div class="mb-4">
                    <label for="fecha_inicio" class="block text-gray-700">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ $clase->fecha_inicio }}"
                        min="{{ now()->format('Y-m-d') }}" max="{{ now()->addMonths(3)->format('Y-m-d') }}"
                        class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Fecha fin -->
                <div class="mb-4">
                    <label for="fecha_fin" class="block text-gray-700">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ $clase->fecha_fin }}"
                        min="{{ now()->format('Y-m-d') }}" max="{{ now()->addMonths(3)->format('Y-m-d') }}"
                        class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Duración -->
                <div class="mb-4">
                    <label for="duracion" class="block text-gray-700">Duración (minutos)</label>
                    <input type="number" name="duracion" id="duracion" value="{{ $clase->duracion }}"
                        class="w-full p-3 border border-gray-300 rounded">
                </div>

                <!-- Ubicación -->
                <div class="mb-4">
                    <label for="ubicacion" class="block text-gray-700">Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ $clase->ubicacion }}"
                        class="w-full p-3 border border-gray-300 rounded">
                </div>

                <!-- Nivel -->
                <div class="mb-4">
                    <label for="nivel" class="block text-gray-700">Nivel</label>
                    <select name="nivel" id="nivel" class="w-full p-3 border border-gray-300 rounded">
                        <option value="">Seleccionar nivel</option>
                        <option value="principiante" {{ $clase->nivel == 'principiante' ? 'selected' : '' }}>
                            Principiante</option>
                        <option value="intermedio" {{ $clase->nivel == 'intermedio' ? 'selected' : '' }}>Intermedio
                        </option>
                        <option value="avanzado" {{ $clase->nivel == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
                    </select>
                </div>

                <!-- Cupos máximos -->
                <div class="mb-4">
                    <label for="cupos_maximos" class="block text-gray-700">Cupos Máximos</label>
                    <input type="number" name="cupos_maximos" id="cupos_maximos" value="{{ $clase->cupos_maximos }}"
                        min="5" max="30" class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Botón de Actualizar Clase -->
                <div class="mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg">
                        Actualizar Clase
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
