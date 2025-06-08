<x-app-layout>
    <div class="container mx-auto px-4 py-8 bg-gray-900 text-gray-100 min-h-screen">
        <div class="mb-8 flex justify-between items-center">
            <h2 class="text-4xl font-extrabold tracking-tight text-white">Crear Nueva Clase</h2>
            <a href="{{ route('admin-entrenador.clases.index') }}"
                class="inline-flex items-center gap-2 px-5 py-3 bg-blue-700 hover:bg-blue-800 rounded-lg shadow-md font-semibold transition ease-in-out duration-200 transform hover:scale-105">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Volver al listado
            </a>
        </div>

        <form action="{{ route('admin-entrenador.clases-individuales.store') }}" method="POST" class="space-y-8" id="claseForm">
            @csrf

            @if ($errors->any())
                <div
                    class="bg-red-700 border border-red-800 text-white px-5 py-4 rounded-lg mb-6 shadow-md animate-fade-in">
                    <ul class="list-disc pl-6 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-700 space-y-6">
                <h3 class="text-2xl font-bold text-white mb-4 pb-3 border-b-2 border-red-500">Detalles Esenciales de la
                    Clase</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div class="md:col-span-2">
                        <label for="nombre" class="block text-white font-semibold mb-2">Nombre de la Clase <span
                                class="text-red-400">*</span></label>
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}"
                            placeholder="Ej: Yoga para principiantes"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                            required>
                    </div>

                    {{-- Descripción --}}
                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-white font-semibold mb-2">Descripción Breve <span
                                class="text-red-400">*</span></label>
                        <textarea name="descripcion" id="descripcion" rows="3"
                            placeholder="Describe de qué trata la clase en pocas palabras..."
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg resize-none focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                            required>{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-700 space-y-6">
                <h3 class="text-2xl font-bold text-white mb-4 pb-3 border-b-2 border-red-500">Programación de la Clase
                </h3>
                <div class="grid grid-cols-1 gap-6">

                    <div class="mb-6">
                        <label for="tipo_programacion" class="block text-white font-semibold mb-2">Tipo de programación
                            <span class="text-red-400">*</span></label>
                        <select name="tipo_programacion" id="tipo_programacion" required
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none"
                            onchange="handleTipoProgramacionChange()">
                            <option value="" disabled {{ old('tipo_programacion') == '' ? 'selected' : '' }}>
                                Selecciona tipo</option>
                            <option value="semanal" {{ old('tipo_programacion') == 'semanal' ? 'selected' : '' }}>
                                Semanal (se repite por días/periodos)</option>
                            <option value="unica" {{ old('tipo_programacion') == 'unica' ? 'selected' : '' }}>Única
                                (fecha y hora específicas)</option>
                        </select>
                    </div>

                    {{-- Selector de frecuencia (solo visible si tipo_programacion = semanal) --}}
                    <div class="mb-6" id="frecuenciaContainer" style="display: none;">
                        <label for="frecuencia" class="block text-white font-semibold mb-2">Frecuencia de Repetición
                            <span class="text-red-400">*</span></label>
                        <select name="frecuencia" id="frecuencia"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                            <option value="" disabled {{ old('frecuencia') == '' ? 'selected' : '' }}>Seleccionar
                                frecuencia</option>
                            <option value="dia" {{ old('frecuencia') == 'dia' ? 'selected' : '' }}>Diaria</option>
                            <option value="semana" {{ old('frecuencia') == 'semana' ? 'selected' : '' }}>Semanal
                            </option>
                            <option value="mes" {{ old('frecuencia') == 'mes' ? 'selected' : '' }}>Mensual</option>
                        </select>
                    </div>

                    {{-- Días de la semana (solo si frecuencia = semanal) --}}
                    <div id="diasSemanaContainer" class="p-4 bg-gray-700 rounded-lg border border-gray-600 mb-6 hidden">
                        <label class="block text-white font-semibold mb-2">Días de la Semana <span
                                class="text-red-400">*</span></label>
                        <div class="flex flex-wrap gap-4">
                            @php
                                $dias_semana_seleccionados = old('dias_semana', []);
                            @endphp
                            @foreach (['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'] as $dia)
                                <label
                                    class="flex items-center text-white space-x-2 cursor-pointer hover:text-red-300 transition-colors">
                                    <input type="checkbox" name="dias_semana[]" value="{{ $dia }}"
                                        class="text-red-500 focus:ring-red-500 border-gray-300 rounded"
                                        {{ in_array($dia, $dias_semana_seleccionados) ? 'checked' : '' }}>
                                    <span>{{ ucfirst($dia) }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p class="text-sm text-gray-400 mt-2">Selecciona los días en que esta clase se repetirá
                            semanalmente.</p>
                    </div>

                    {{-- Día del mes (solo si frecuencia = mensual) --}}
                    <div id="diaMesContainer" class="p-4 bg-gray-700 rounded-lg border border-gray-600 mb-6 hidden">
                        <label for="dia_mes" class="block text-white font-semibold mb-2">Día del Mes <span
                                class="text-red-400">*</span></label>
                        <input type="number" name="dia_mes" id="dia_mes" min="1" max="31"
                            value="{{ old('dia_mes') }}"
                            class="w-full p-3 bg-gray-600 text-white border border-gray-500 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                            placeholder="Ejemplo: 15 para el día 15 del mes">
                        <p class="text-sm text-gray-400 mt-2">Selecciona el día del mes en que se repetirá esta clase.
                        </p>
                    </div>

                    {{-- Hora de la clase (para programación semanal - diaria, semanal, mensual) --}}
                    <div id="horaClaseContainer" class="mt-6" style="display:none;">
                        <label for="hora_inicio" class="block text-white font-semibold mb-2">Hora de la Clase <span
                                class="text-red-400">*</span></label>
                        <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}"
                            min="08:00" max="23:59"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200">
                        <p class="text-sm text-gray-400 mt-2">Define la hora de inicio para las clases repetitivas
                            (entre 08:00 y 23:59).</p>
                    </div>

                    {{-- Fecha y hora (solo si tipo_programacion = unica) --}}
                    <div id="fechaHoraContainer" class="mb-6" style="display: none;">
                        <label for="fecha_hora" class="block text-white font-semibold mb-2">Fecha y Hora Específica
                            <span class="text-red-400">*</span></label>
                        <input type="datetime-local" name="fecha_hora" id="fecha_hora"
                            value="{{ old('fecha_hora') }}"
                            class="w-full p-3 bg-gray-600 text-white border border-gray-500 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                            required>
                        <p class="text-sm text-gray-400 mt-2">Esta clase se impartirá solo en la fecha y hora
                            seleccionadas.</p>
                    </div>

                    {{-- Fecha Inicio de la Clase (solo si tipo_programacion = semanal) --}}
                    <div id="fechaInicioContainer" class="mb-6" style="display: none;">
                        <label for="fecha_inicio" class="block text-white font-semibold mb-2">Fecha de Inicio <span
                                class="text-red-400">*</span></label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio"
                            value="{{ old('fecha_inicio') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                            min="{{ date('Y-m-d') }}" required>
                        <p class="text-sm text-gray-400 mt-2">Fecha de inicio de la clase o serie de clases.</p>
                    </div>

                    {{-- Fecha Fin de la Clase (siempre visible y obligatoria) --}}
                    <div id="fechaFinContainer" class="mt-6">
                        <label for="fecha_fin" class="block text-white font-semibold mb-2">Fecha de Fin <span
                                class="text-red-400">*</span></label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                            min="{{ date('Y-m-d') }}" required>
                        <p class="text-sm text-gray-400 mt-2">Último día que la clase estará disponible.</p>
                    </div>

                    <div class="bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-700 space-y-6">
                        <h3 class="text-2xl font-bold text-white mb-4 pb-3 border-b-2 border-red-500">Asignación de
                            Entrenador y Sala</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Entrenador --}}
                            <div>
                                <label for="entrenador_id" class="block text-white font-semibold mb-2">Entrenador
                                    Asignado <span class="text-red-400">*</span></label>
                                <select name="entrenador_id" id="entrenador_id" required
                                    class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                                    <option value="" disabled
                                        {{ old('entrenador_id') == '' ? 'selected' : '' }}>Seleccionar Entrenador
                                    </option>
                                    @foreach ($entrenadores as $entrenador)
                                        <option value="{{ $entrenador->id }}"
                                            {{ old('entrenador_id') == $entrenador->id ? 'selected' : '' }}>
                                            {{ $entrenador->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Ubicación (Desplegable de Zonas/Salas) --}}
                            <div>
                                <label for="lugar" class="block text-white font-semibold mb-2">Sala / Ubicación
                                    <span class="text-red-400">*</span></label>
                                <select name="lugar" id="lugar" required
                                    class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                                    <option value="" disabled {{ old('lugar') == '' ? 'selected' : '' }}>
                                        Seleccionar Sala/Zona</option>
                                    <option value="Sala Principal"
                                        {{ old('lugar') == 'Sala Principal' ? 'selected' : '' }}>Sala Principal
                                    </option>
                                    <option value="Sala de Spinning"
                                        {{ old('lugar') == 'Sala de Spinning' ? 'selected' : '' }}>Sala de Spinning
                                    </option>
                                    <option value="Zona de Yoga"
                                        {{ old('lugar') == 'Zona de Yoga' ? 'selected' : '' }}>Zona de Yoga
                                    </option>
                                    <option value="Sala de Pesas"
                                        {{ old('lugar') == 'Sala de Pesas' ? 'selected' : '' }}>Sala de Pesas
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-800 shadow-lg rounded-xl p-8 border border-gray-700 space-y-6">
                        <h3 class="text-2xl font-bold text-white mb-4 pb-3 border-b-2 border-red-500">Detalles Técnicos
                            y Nivel</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Capacidad Máxima (Cupos) --}}
                            <div>
                                <label for="cupos_maximos" class="block text-white font-semibold mb-2">Capacidad
                                    Máxima <span class="text-red-400">*</span></label>
                                <input type="number" name="cupos_maximos" id="cupos_maximos"
                                    value="{{ old('cupos_maximos') }}" min="5" max="20"
                                    class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                                    placeholder="Entre 5 y 20" required>
                            </div>

                            {{-- Duración --}}
                            <div>
                                <label for="duracion" class="block text-white font-semibold mb-2">Duración (minutos)
                                    <span class="text-red-400">*</span></label>
                                <input type="number" name="duracion" id="duracion" value="{{ old('duracion') }}"
                                    min="10" max="180"
                                    class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200"
                                    placeholder="Ej: 60" required>
                            </div>

                            {{-- Nivel --}}
                            <div class="md:col-span-2">
                                <label for="nivel" class="block text-white font-semibold mb-2">Nivel de la Clase
                                    <span class="text-red-400">*</span></label>
                                <select name="nivel" id="nivel" required
                                    class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                                    <option value="" disabled {{ old('nivel') == '' ? 'selected' : '' }}>
                                        Seleccionar nivel</option>
                                    <option value="principiante"
                                        {{ old('nivel') == 'principiante' ? 'selected' : '' }}>Principiante</option>
                                    <option value="intermedio" {{ old('nivel') == 'intermedio' ? 'selected' : '' }}>
                                        Intermedio</option>
                                    <option value="avanzado" {{ old('nivel') == 'avanzado' ? 'selected' : '' }}>
                                        Avanzado</option>
                                    <option value="todos" {{ old('nivel') == 'todos' ? 'selected' : '' }}>Todos los
                                        niveles</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-lg font-semibold shadow-md transition transform hover:scale-105">Crear
                            Clase</button>
                    </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function handleTipoProgramacionChange() {
                const tipo = document.getElementById('tipo_programacion').value;

                const frecuenciaContainer = document.getElementById('frecuenciaContainer');
                const diasSemanaContainer = document.getElementById('diasSemanaContainer');
                const diaMesContainer = document.getElementById('diaMesContainer');
                const horaClaseContainer = document.getElementById('horaClaseContainer');
                const fechaHoraContainer = document.getElementById('fechaHoraContainer');
                const fechaInicioContainer = document.getElementById('fechaInicioContainer');
                const fechaInicioInput = document.getElementById('fecha_inicio');
                const fechaHoraInput = document.getElementById('fecha_hora');

                if (tipo === 'unica') {
                    // Mostrar solo fecha y hora específicas
                    fechaHoraContainer.style.display = 'block';
                    fechaHoraInput.required = true;

                    // Ocultar frecuencia, días de semana, día mes, hora, fecha inicio
                    frecuenciaContainer.style.display = 'none';
                    diasSemanaContainer.classList.add('hidden');
                    diaMesContainer.classList.add('hidden');
                    horaClaseContainer.style.display = 'none';
                    fechaInicioContainer.style.display = 'none';
                    fechaInicioInput.required = false;
                } else if (tipo === 'semanal') {
                    // Mostrar campos para programación semanal
                    frecuenciaContainer.style.display = 'block';
                    fechaHoraContainer.style.display = 'none';
                    fechaHoraInput.required = false;

                    fechaInicioContainer.style.display = 'block';
                    fechaInicioInput.required = true;

                    // Mostrar hora clase y ocultar días según frecuencia luego
                    horaClaseContainer.style.display = 'block';

                    // Aquí puedes añadir lógica para mostrar u ocultar diasSemanaContainer y diaMesContainer según la frecuencia seleccionada
                } else {
                    // Ocultar todos los campos relacionados
                    frecuenciaContainer.style.display = 'none';
                    diasSemanaContainer.classList.add('hidden');
                    diaMesContainer.classList.add('hidden');
                    horaClaseContainer.style.display = 'none';
                    fechaHoraContainer.style.display = 'none';
                    fechaHoraInput.required = false;
                    fechaInicioContainer.style.display = 'none';
                    fechaInicioInput.required = false;
                }
            }

            document.addEventListener('DOMContentLoaded', () => {
                handleTipoProgramacionChange();

                // Opcional: lógica para mostrar diasSemanaContainer o diaMesContainer según frecuencia seleccionada
                const frecuencia = document.getElementById('frecuencia');
                frecuencia?.addEventListener('change', () => {
                    const frecuenciaVal = frecuencia.value;
                    const diasSemanaContainer = document.getElementById('diasSemanaContainer');
                    const diaMesContainer = document.getElementById('diaMesContainer');

                    if (frecuenciaVal === 'semana') {
                        diasSemanaContainer.classList.remove('hidden');
                        diaMesContainer.classList.add('hidden');
                    } else if (frecuenciaVal === 'mes') {
                        diaMesContainer.classList.remove('hidden');
                        diasSemanaContainer.classList.add('hidden');
                    } else {
                        diasSemanaContainer.classList.add('hidden');
                        diaMesContainer.classList.add('hidden');
                    }
                });

                const fechaFinInput = document.getElementById('fecha_fin');
                fechaFinInput.addEventListener('change', function() {
                    const hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);
                    const seleccionada = new Date(this.value);
                    if (seleccionada < hoy) {
                        alert('La fecha de fin no puede ser anterior a hoy.');
                        this.value = '';
                    }
                });

                // Disparar cambio inicial frecuencia para mostrar el contenedor correcto si hay old value
                frecuencia?.dispatchEvent(new Event('change'));
            });
        </script>
    @endpush
</x-app-layout>
