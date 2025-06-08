<x-app-layout>
    {{-- Contenedor principal con fondo oscuro --}}
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="flex justify-end items-center mb-6">
            <a href="{{ route('admin-entrenador.clases.index') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-700 text-white hover:bg-blue-800 font-semibold rounded-lg transition duration-200 shadow-md">
                <i data-feather="arrow-left" class="w-4 h-4 mr-2"></i> Volver al listado
            </a>
        </div>

        <h1 class="text-3xl font-bold text-white mb-6">Editar Clase: <span
                class="text-red-500">{{ $clase->nombre }}</span></h1>

        <form action="{{ route('admin-entrenador.clases.update', $clase) }}" method="POST">
            @if ($errors->any())
                <div
                    class="bg-red-700 border border-red-800 text-white px-4 py-3 rounded-lg mb-6 shadow-md animate-fade-in">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @csrf
            @method('PUT')
            <div class="bg-gray-800 shadow-lg rounded-xl p-6 border border-gray-700 space-y-6">

                <div>
                    <label for="nombre" class="block text-white font-semibold mb-2">Nombre de la Clase</label>
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $clase->nombre) }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200"
                        required>
                </div>

                <div>
                    <label for="entrenador_id" class="block text-white font-semibold mb-2">Entrenador</label>
                    <select name="entrenador_id" id="entrenador_id"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200 appearance-none"
                        required>
                        <option value="" class="text-gray-400">Seleccionar Entrenador</option>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}"
                                {{ old('entrenador_id', $clase->entrenador_id) == $entrenador->id ? 'selected' : '' }}>
                                {{ $entrenador->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="descripcion" class="block text-white font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="4"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200">{{ old('descripcion', $clase->descripcion) }}</textarea>
                </div>

                <div>
                    <label for="duracion" class="block text-white font-semibold mb-2">Duración (minutos)</label>
                    <input type="number" name="duracion" id="duracion" value="{{ old('duracion', $clase->duracion) }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200"
                        required>
                </div>

                @php
                    $hoy = now()->format('Y-m-d');
                    $maxFecha = now()->addMonths(3)->format('Y-m-d');
                @endphp

                <div>
                    <label for="fecha_inicio" class="block text-white font-semibold mb-2">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio"
                        value="{{ old('fecha_inicio', $clase->fecha_inicio) }}" min="{{ $hoy }}"
                        max="{{ $maxFecha }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200"
                        required>
                </div>

                <div>
                    <label for="fecha_fin" class="block text-white font-semibold mb-2">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" id="fecha_fin"
                        value="{{ old('fecha_fin', $clase->fecha_fin) }}" min="{{ $hoy }}"
                        max="{{ $maxFecha }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200"
                        required>
                </div>

                <div>
                    <label for="ubicacion" class="block text-white font-semibold mb-2">Ubicación</label>
                    <select name="ubicacion" id="ubicacion" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="" disabled
                            {{ old('ubicacion', $clase->ubicacion ?? '') === '' ? 'selected' : '' }}>
                            Seleccionar Sala/Zona
                        </option>
                        <option value="Sala Principal"
                            {{ old('ubicacion', $clase->ubicacion ?? '') === 'Sala Principal' ? 'selected' : '' }}>
                            Sala Principal
                        </option>
                        <option value="Sala de Spinning"
                            {{ old('ubicacion', $clase->ubicacion ?? '') === 'Sala de Spinning' ? 'selected' : '' }}>
                            Sala de Spinning
                        </option>
                        <option value="Zona de Yoga"
                            {{ old('ubicacion', $clase->ubicacion ?? '') === 'Zona de Yoga' ? 'selected' : '' }}>
                            Zona de Yoga
                        </option>
                        <option value="Sala de Pesas"
                            {{ old('ubicacion', $clase->ubicacion ?? '') === 'Sala de Pesas' ? 'selected' : '' }}>
                            Sala de Pesas
                        </option>
                    </select>
                </div>


                <div>
                    <label for="nivel" class="block text-white font-semibold mb-2">Nivel</label>
                    <select name="nivel" id="nivel"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="" class="text-gray-400">Seleccionar nivel</option>
                        <option value="principiante"
                            {{ old('nivel', $clase->nivel) == 'principiante' ? 'selected' : '' }}>
                            Principiante</option>
                        <option value="intermedio"
                            {{ old('nivel', $clase->nivel) == 'intermedio' ? 'selected' : '' }}>Intermedio
                        </option>
                        <option value="avanzado" {{ old('nivel', $clase->nivel) == 'avanzado' ? 'selected' : '' }}>
                            Avanzado
                        </option>
                    </select>
                </div>

                <div>
                    <label for="cupos_maximos" class="block text-white font-semibold mb-2">Cupos Máximos</label>
                    <input type="number" name="cupos_maximos" id="cupos_maximos"
                        value="{{ old('cupos_maximos', $clase->cupos_maximos) }}" min="5" max="30"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200"
                        required>
                </div>

                {{-- Nuevo campo frecuencia --}}
                <div>
                    <label for="frecuencia" class="block text-white font-semibold mb-2">Frecuencia</label>
                    <select name="frecuencia" id="frecuencia"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-red-500 transition duration-200 appearance-none"
                        required>
                        <option value="dia" {{ old('frecuencia', $clase->frecuencia) == 'dia' ? 'selected' : '' }}>
                            Diaria
                        </option>
                        <option value="semana"
                            {{ old('frecuencia', $clase->frecuencia) == 'semana' ? 'selected' : '' }}>Semanal
                        </option>
                        <option value="mes" {{ old('frecuencia', $clase->frecuencia) == 'mes' ? 'selected' : '' }}>
                            Mensual
                        </option>
                    </select>
                </div>

                {{-- Checkbox días de la semana --}}
                @php
                    $diasSemana = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                    $diasSeleccionados = old('dias_semana', $clase->dias_semana ?? []);
                @endphp

                <div id="dias_semana_container"
                    class="mt-4 {{ in_array(old('frecuencia', $clase->frecuencia), ['semana', 'mes']) ? '' : 'hidden' }}">
                    <label class="block text-white font-semibold mb-2">Días de la Semana</label>
                    <div class="grid grid-cols-4 gap-2">
                        @foreach ($diasSemana as $dia)
                            <label class="inline-flex items-center space-x-2 cursor-pointer">
                                <input type="checkbox" name="dias_semana[]" value="{{ $dia }}"
                                    {{ in_array($dia, $diasSeleccionados) ? 'checked' : '' }}
                                    class="form-checkbox text-red-500">
                                <span class="text-white capitalize">{{ $dia }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 flex justify-end">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-200 transform hover:scale-105">
                        Actualizar Clase
                    </button>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function() {

                // Date input min/max and validation logic (similar to create)
                const fechaInicio = document.getElementById('fecha_inicio');
                const fechaFin = document.getElementById('fecha_fin');

                const hoy = new Date();
                const maxFecha = new Date();
                maxFecha.setMonth(hoy.getMonth() + 3);

                const formatDate = (date) => {
                    const year = date.getFullYear();
                    const month = String(date.getMonth() + 1).padStart(2, '0');
                    const day = String(date.getDate()).padStart(2, '0');
                    return `${year}-${month}-${day}`;
                };

                // Apply initial min/max attributes if not already set by Blade
                fechaInicio.min = fechaInicio.min || formatDate(hoy);
                fechaInicio.max = fechaInicio.max || formatDate(maxFecha);
                fechaFin.min = fechaFin.min || formatDate(hoy);
                fechaFin.max = fechaFin.max || formatDate(maxFecha);

                fechaInicio.addEventListener('change', () => {
                    if (fechaInicio.value) {
                        fechaFin.min = fechaInicio.value;
                        if (fechaFin.value && fechaFin.value < fechaInicio.value) {
                            fechaFin.value = fechaInicio.value;
                        }
                    } else {
                        fechaFin.min = formatDate(hoy);
                    }
                });

                fechaFin.addEventListener('change', () => {
                    if (fechaFin.value) {
                        fechaInicio.max = fechaFin.value;
                        if (fechaInicio.value && fechaInicio.value > fechaFin.value) {
                            fechaInicio.value = fechaFin.value;
                        }
                    } else {
                        fechaInicio.max = formatDate(maxFecha);
                    }
                });

                // Función para mostrar u ocultar el contenedor de días de la semana
                function toggleDiasSemana() {
                    const frecuencia = document.getElementById('frecuencia').value;
                    const diasContainer = document.getElementById('dias_semana_container');

                    if (frecuencia === 'semana' || frecuencia === 'mes') {
                        diasContainer.classList.remove('hidden');
                    } else {
                        diasContainer.classList.add('hidden');
                        // Deselecciona todos los checkboxes cuando se oculta
                        diasContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
                    }
                }

                // Evento al cambiar la frecuencia
                document.getElementById('frecuencia').addEventListener('change', toggleDiasSemana);

                // Ejecutar al cargar para mostrar/ocultar correctamente
                toggleDiasSemana();
            });
        </script>
    @endpush
</x-app-layout>
