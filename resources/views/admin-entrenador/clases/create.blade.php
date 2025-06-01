<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-3xl font-bold text-white">Crear Nueva Clase</h2>
            <a href="{{ route('admin-entrenador.clases.index') }}" {{-- Cambiado a ruta de Listado de Clases --}}
               class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver al listado
            </a>
        </div>

        <form action="{{ route('admin-entrenador.clases.store') }}" method="POST">
            @if ($errors->any())
                <div class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @csrf
            <div class="bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-700 space-y-6">

                <div>
                    <label for="nombre" class="block text-white font-semibold mb-2">Nombre de la Clase</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                </div>

                <div>
                    <label for="descripcion" class="block text-white font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>{{ old('descripcion') }}</textarea>
                </div>

                <div>
                    <label for="entrenador_id" class="block text-white font-semibold mb-2">Entrenador</label>
                    <select name="entrenador_id" id="entrenador_id"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200 appearance-none" required>
                        <option value="" class="text-gray-400">Seleccionar Entrenador</option>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}" @selected(old('entrenador_id') == $entrenador->id)>{{ $entrenador->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="duracion" class="block text-white font-semibold mb-2">Duración (minutos)</label>
                    <input type="number" name="duracion" id="duracion" value="{{ old('duracion') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                </div>

                @php
                    $hoy = now()->format('Y-m-d');
                    $maxFecha = now()->addMonths(3)->format('Y-m-d');
                @endphp

                <div>
                    <label for="fecha_inicio" class="block text-white font-semibold mb-2">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio', $hoy) }}"
                        min="{{ $hoy }}" max="{{ $maxFecha }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                </div>

                <div>
                    <label for="fecha_fin" class="block text-white font-semibold mb-2">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"
                        min="{{ $hoy }}" max="{{ $maxFecha }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required>
                </div>

                <div>
                    <label for="cupos_maximos" class="block text-white font-semibold mb-2">Capacidad Máxima</label>
                    <input type="number" name="cupos_maximos" id="cupos_maximos" value="{{ old('cupos_maximos') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200" required min="5" max="20">
                </div>

                <div>
                    <label for="ubicacion" class="block text-white font-semibold mb-2">Sala / Ubicación</label>
                    <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200">
                </div>

                <div>
                    <label for="nivel" class="block text-white font-semibold mb-2">Nivel</label>
                    <select name="nivel" id="nivel"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="" class="text-gray-400">Seleccionar nivel</option>
                        <option value="principiante" @selected(old('nivel') == 'principiante')>Principiante</option>
                        <option value="intermedio" @selected(old('nivel') == 'intermedio')>Intermedio</option>
                        <option value="avanzado" @selected(old('nivel') == 'avanzado')>Avanzado</option>
                    </select>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                        Crear Clase
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const fechaInicio = document.getElementById('fecha_inicio');
                const fechaFin = document.getElementById('fecha_fin');

                const hoy = new Date();
                const maxFecha = new Date();
                maxFecha.setMonth(hoy.getMonth() + 3); // 3 meses desde hoy

                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                };

                fechaInicio.min = formatDate(hoy);
                fechaInicio.max = formatDate(maxFecha);
                fechaFin.min = formatDate(hoy); // Inicialmente, fin puede ser hoy
                fechaFin.max = formatDate(maxFecha);

                // Asegurar que fecha_fin no sea anterior a fecha_inicio
                fechaInicio.addEventListener('change', () => {
                    if (fechaInicio.value) {
                        fechaFin.min = fechaInicio.value;
                        if (fechaFin.value < fechaInicio.value) {
                            fechaFin.value = fechaInicio.value;
                        }
                    } else {
                        fechaFin.min = formatDate(hoy);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
