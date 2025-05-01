<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold mb-6">Crear Nueva Clase</h1>

        <form action="{{ route('admin-entrenador.clases.store') }}" method="POST">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf
            <div class="bg-white shadow rounded-xl p-6">

                <!-- Nombre de la clase -->
                <div class="mb-4">
                    <label for="nombre" class="block text-gray-700">Nombre de la Clase</label>
                    <input type="text" name="nombre" id="nombre"
                        class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <label for="descripcion" class="block text-gray-700">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4" class="w-full p-3 border border-gray-300 rounded" required></textarea>
                </div>

                <!-- Selección de Entrenador -->
                <div class="mb-4">
                    <label for="entrenador_id" class="block text-gray-700">Entrenador</label>
                    <select name="entrenador_id" id="entrenador_id" class="w-full p-3 border border-gray-300 rounded"
                        required>
                        <option value="">Seleccionar Entrenador</option>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}">{{ $entrenador->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Duración en minutos -->
                <div class="mb-4">
                    <label for="duracion" class="block text-gray-700">Duración (minutos)</label>
                    <input type="number" name="duracion" id="duracion"
                        class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                @php
                    $hoy = now()->format('Y-m-d');
                    $maxFecha = now()->addMonths(3)->format('Y-m-d');
                @endphp

                <!-- Fecha de inicio -->
                <div class="mb-4">
                    <label for="fecha_inicio" class="block text-gray-700">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" min="{{ $hoy }}"
                        max="{{ $maxFecha }}" class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Fecha de fin -->
                <div class="mb-4">
                    <label for="fecha_fin" class="block text-gray-700">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" min="{{ $hoy }}"
                        max="{{ $maxFecha }}" class="w-full p-3 border border-gray-300 rounded" required>
                </div>

                <!-- Capacidad máxima -->
                <div class="mb-4">
                    <label for="cupos_maximos" class="block text-gray-700">Capacidad Máxima</label>
                    <input type="number" name="cupos_maximos" id="cupos_maximos"
                        class="w-full p-3 border border-gray-300 rounded" required min="5" max="20">
                </div>


                <!-- Sala o ubicación -->
                <div class="mb-4">
                    <label for="ubicacion" class="block text-gray-700">Sala / Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion"
                        class="w-full p-3 border border-gray-300 rounded">
                </div>

                <!-- Nivel (opcional) -->
                <div class="mb-4">
                    <label for="nivel" class="block text-gray-700">Nivel</label>
                    <select name="nivel" id="nivel" class="w-full p-3 border border-gray-300 rounded">
                        <option value="">Seleccionar nivel</option>
                        <option value="principiante">Principiante</option>
                        <option value="intermedio">Intermedio</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                </div>

                <!-- Botón de Crear Clase -->
                <div class="mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-lg">
                        Crear Clase
                    </button>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const fechaInicio = document.getElementById('fecha_inicio');
                    const fechaFin = document.getElementById('fecha_fin');

                    const hoy = new Date();
                    const maxFecha = new Date();
                    maxFecha.setMonth(hoy.getMonth() + 3);

                    const formatDate = (date) => {
                        return date.toISOString().split('T')[0];
                    };

                    fechaInicio.min = formatDate(hoy);
                    fechaInicio.max = formatDate(maxFecha);
                    fechaFin.min = formatDate(hoy);
                    fechaFin.max = formatDate(maxFecha);

                    // Cuando cambia la fecha de inicio, actualiza el mínimo permitido para fecha_fin
                    fechaInicio.addEventListener('change', () => {
                        if (fechaInicio.value) {
                            fechaFin.min = fechaInicio.value;
                        } else {
                            fechaFin.min = formatDate(hoy);
                        }
                    });
                });
            </script>

        </form>
    </div>
</x-app-layout>
