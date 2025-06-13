<x-app-layout>
    {{-- Elimina el bg-gray-950 de aquí si ya está en x-app-layout --}}
    <div class="container mx-auto px-4 py-8 text-gray-100 min-h-screen">
        {{-- Ajusta el padding superior del h2 para que no esté tan pegado al borde --}}
        <div class="mb-10 pt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">Crear Nueva Clase <span class="text-red-500">Individual</span></h2>
            <a href="{{ route('entrenador.clases.index') }}"
                class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl shadow-lg font-semibold transition ease-in-out duration-300 transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 -ml-1" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Volver al listado
            </a>
        </div>

        <form action="{{ route('entrenador.clases-individuales.store') }}" method="POST" class="space-y-10" id="claseForm">
            @csrf

            @if ($errors->any())
                <div class="bg-red-800 border border-red-700 text-white px-6 py-5 rounded-xl mb-8 shadow-xl animate-fade-in" role="alert">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-white mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h4 class="font-bold text-lg">Errores en el formulario:</h4>
                    </div>
                    <ul class="mt-3 list-disc pl-8 space-y-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Sección: Detalles Esenciales de la Clase --}}
            <div class="bg-gray-800 shadow-2xl rounded-2xl p-8 lg:p-10 border border-gray-700 space-y-8 animate-fade-in-up">
                <h3 class="text-3xl font-bold text-white mb-6 pb-4 border-b-2 border-red-500 text-center">Detalles Esenciales de la Clase</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Nombre --}}
                    <div class="md:col-span-2">
                        <label for="titulo" class="block text-gray-200 font-semibold mb-2 text-lg">Nombre de la Clase <span class="text-red-400">*</span></label>
                        <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}"
                            placeholder="Ej: Sesión de Entrenamiento de Fuerza"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 placeholder-gray-400 text-base">
                    </div>

                    {{-- Descripción --}}
                    <div class="md:col-span-2">
                        <label for="descripcion" class="block text-gray-200 font-semibold mb-2 text-lg">Descripción Breve <span class="text-red-400">*</span></label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                            placeholder="Describe de qué trata la clase en pocas palabras. Sé conciso y claro."
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg resize-y focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 placeholder-gray-400 text-base">{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Sección: Programación de la Clase --}}
            <div class="bg-gray-800 shadow-2xl rounded-2xl p-8 lg:p-10 border border-gray-700 space-y-8 animate-fade-in-up delay-100">
                <h3 class="text-3xl font-bold text-white mb-6 pb-4 border-b-2 border-red-500 text-center">Programación de la Clase</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                    {{-- Select de frecuencia --}}
                    <div>
                        <label for="frecuencia" class="block text-gray-200 font-semibold mb-2 text-lg">
                            Tipo de programación <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <select name="frecuencia" id="frecuencia" required onchange="handleFrecuenciaChange()"
                                class="w-full p-4 pr-10 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 appearance-none cursor-pointer text-base">
                                <option value="" disabled {{ old('frecuencia') == '' ? 'selected' : '' }}>Selecciona tipo</option>
                                <option value="unica" {{ old('frecuencia') == 'unica' ? 'selected' : '' }}>Única (fecha y hora específicas)</option>
                                <option value="semanal" {{ old('frecuencia') == 'semanal' ? 'selected' : '' }}>Semanal (se repite por días)</option>
                                <option value="mensual" {{ old('frecuencia') == 'mensual' ? 'selected' : '' }}>Mensual (día del mes)</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Duración --}}
                    <div>
                        <label for="duracion" class="block text-gray-200 font-semibold mb-2 text-lg">Duración (minutos) <span class="text-red-400">*</span></label>
                        <input type="number" name="duracion" id="duracion" value="{{ old('duracion') }}" min="10" max="180"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 placeholder-gray-400 text-base"
                            placeholder="Ej: 60" required>
                    </div>

                    {{-- Contenedores condicionales --}}
                    <div id="diasSemanaContainer" class="md:col-span-2 p-6 bg-gray-700 rounded-xl border border-gray-600 hidden transition-all duration-500 ease-in-out">
                        <label class="block text-gray-200 font-semibold mb-4 text-lg">
                            Días de la Semana <span class="text-red-400">*</span>
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                            @php
                                $dias_semana_seleccionados = old('dias_semana', []);
                            @endphp
@foreach (['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'] as $dia)
    <label class="flex items-center text-gray-200 space-x-3 cursor-pointer hover:text-red-300 transition-colors">
        <input type="checkbox" name="dias_semana[]" value="{{ $dia }}"
            class="h-5 w-5 text-red-500 focus:ring-red-500 border-gray-500 rounded-md bg-gray-900 form-checkbox"
            {{ in_array($dia, $dias_semana_seleccionados) ? 'checked' : '' }}>
        <span class="text-base">{{ ucfirst($dia) }}</span>
    </label>
@endforeach

                        </div>
                        <p class="text-sm text-gray-400 mt-4">Selecciona los días en que esta clase se repetirá semanalmente.</p>
                    </div>

                    <div id="diaMesContainer" class="md:col-span-2 p-6 bg-gray-700 rounded-xl border border-gray-600 hidden transition-all duration-500 ease-in-out">
                        <label for="dia_mes" class="block text-gray-200 font-semibold mb-2 text-lg">
                            Día del Mes <span class="text-red-400">*</span>
                        </label>
                        <input type="number" name="dia_mes" id="dia_mes" min="1" max="31"
                            value="{{ old('dia_mes') }}"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 placeholder-gray-400 text-base"
                            placeholder="Ejemplo: 15 para el día 15 del mes">
                        <p class="text-sm text-gray-400 mt-4">Selecciona el día del mes en que se repetirá esta clase.</p>
                    </div>

                    <div id="horaClaseContainer" class="hidden transition-all duration-500 ease-in-out">
                        <label for="hora_inicio" class="block text-gray-200 font-semibold mb-2 text-lg">
                            Hora de la Clase <span class="text-red-400">*</span>
                        </label>
                        <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}"
                            min="08:00" max="23:59"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 text-base">
                        <p class="text-sm text-gray-400 mt-4">Define la hora de inicio para las clases repetitivas (entre 08:00 y 23:59).</p>
                    </div>

                    <div id="fechaHoraContainer" class="hidden transition-all duration-500 ease-in-out">
                        <label for="fecha_hora" class="block text-gray-200 font-semibold mb-2 text-lg">
                            Fecha y Hora Específica <span class="text-red-400">*</span>
                        </label>
                        <input type="datetime-local" name="fecha_hora" id="fecha_hora"
                            value="{{ old('fecha_hora') }}"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 text-base">
                        <p class="text-sm text-gray-400 mt-4">Esta clase se impartirá solo en la fecha y hora seleccionadas.</p>
                    </div>

                    <div id="fechaInicioContainer" class="hidden transition-all duration-500 ease-in-out">
                        <label for="fecha_inicio" class="block text-gray-200 font-semibold mb-2 text-lg">
                            Fecha de Inicio <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio"
                            value="{{ old('fecha_inicio') }}"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 text-base"
                            min="{{ date('Y-m-d') }}">
                        <p class="text-sm text-gray-400 mt-4">Fecha de inicio de la clase o serie de clases.</p>
                    </div>

                    {{-- Fecha fin (siempre visible y obligatoria) --}}
                    <div id="fechaFinContainer">
                        <label for="fecha_fin" class="block text-gray-200 font-semibold mb-2 text-lg">
                            Fecha de Fin <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"
                            class="w-full p-4 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 text-base"
                            min="{{ date('Y-m-d') }}" required>
                        <p class="text-sm text-gray-400 mt-4">Último día que la clase estará disponible.</p>
                    </div>
                </div>
            </div>

            {{-- Sección: Asignación de Cliente y Sala --}}
            <div class="bg-gray-800 shadow-2xl rounded-2xl p-8 lg:p-10 border border-gray-700 space-y-8 animate-fade-in-up delay-200">
                <h3 class="text-3xl font-bold text-white mb-6 pb-4 border-b-2 border-red-500 text-center">Asignación de Cliente y Sala</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Cliente asignado --}}
                    <div>
                        <label for="usuario_id" class="block text-gray-200 font-semibold mb-2 text-lg">Cliente Asignado <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="usuario_id" id="usuario_id" required
                                class="w-full p-4 pr-10 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 appearance-none cursor-pointer text-base">
                                <option value="" class="text-gray-400">Seleccionar cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" @selected(old('usuario_id') == $cliente->id)>
                                        {{ $cliente->name }} ({{ $cliente->email }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Ubicación (Desplegable de Zonas/Salas) --}}
                    <div>
                        <label for="lugar" class="block text-gray-200 font-semibold mb-2 text-lg">Sala / Ubicación <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="lugar" id="lugar" required
                                class="w-full p-4 pr-10 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 appearance-none cursor-pointer text-base">
                                <option value="" disabled {{ old('lugar') == '' ? 'selected' : '' }}>Seleccionar Sala/Zona</option>
                                <option value="Sala Principal" {{ old('lugar') == 'Sala Principal' ? 'selected' : '' }}>Sala Principal</option>
                                <option value="Sala de Spinning" {{ old('lugar') == 'Sala de Spinning' ? 'selected' : '' }}>Sala de Spinning</option>
                                <option value="Zona de Yoga" {{ old('lugar') == 'Zona de Yoga' ? 'selected' : '' }}>Zona de Yoga</option>
                                <option value="Sala de Pesas" {{ old('lugar') == 'Sala de Pesas' ? 'selected' : '' }}>Sala de Pesas</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sección: Detalles Técnicos y Nivel --}}
            <div class="bg-gray-800 shadow-2xl rounded-2xl p-8 lg:p-10 border border-gray-700 space-y-8 animate-fade-in-up delay-300">
                <h3 class="text-3xl font-bold text-white mb-6 pb-4 border-b-2 border-red-500 text-center">Detalles Técnicos y Nivel</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Nivel --}}
                    <div class="md:col-span-2">
                        <label for="nivel" class="block text-gray-200 font-semibold mb-2 text-lg">Nivel de la Clase <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <select name="nivel" id="nivel" required
                                class="w-full p-4 pr-10 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-2 focus:ring-red-500 transition duration-300 appearance-none cursor-pointer text-base">
                                <option value="" disabled {{ old('nivel') == '' ? 'selected' : '' }}>Seleccionar nivel</option>
                                <option value="principiante" {{ old('nivel') == 'principiante' ? 'selected' : '' }}>Principiante</option>
                                <option value="intermedio" {{ old('nivel') == 'intermedio' ? 'selected' : '' }}>Intermedio</option>
                                <option value="avanzado" {{ old('nivel') == 'avanzado' ? 'selected' : '' }}>Avanzado</option>
                                <option value="todos" {{ old('nivel') == 'todos' ? 'selected' : '' }}>Todos los niveles</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Botón de Enviar --}}
            <div class="flex justify-end pt-6">
                <button type="submit"
                    class="px-10 py-4 bg-red-600 hover:bg-red-700 text-white rounded-xl font-bold shadow-lg transition transform hover:scale-105 active:scale-95 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-900 text-lg">
                    Crear Clase
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function handleFrecuenciaChange() {
                const frecuencia = document.getElementById('frecuencia').value;

                const diasSemanaContainer = document.getElementById('diasSemanaContainer');
                const diaMesContainer = document.getElementById('diaMesContainer');
                const horaClaseContainer = document.getElementById('horaClaseContainer');
                const fechaHoraContainer = document.getElementById('fechaHoraContainer');
                const fechaInicioContainer = document.getElementById('fechaInicioContainer');

                const fechaHoraInput = document.getElementById('fecha_hora');
                const horaInicioInput = document.getElementById('hora_inicio');
                const fechaInicioInput = document.getElementById('fecha_inicio');
                const diaMesInput = document.getElementById('dia_mes');

                // Ocultar todo inicialmente
                diasSemanaContainer.classList.add('hidden');
                diaMesContainer.classList.add('hidden');
                horaClaseContainer.classList.add('hidden');
                fechaHoraContainer.classList.add('hidden');
                fechaInicioContainer.classList.add('hidden');

                // Quitar requerimientos
                fechaHoraInput.required = false;
                horaInicioInput.required = false;
                fechaInicioInput.required = false;
                diaMesInput.required = false;

                if (frecuencia === 'unica') {
                    fechaHoraContainer.classList.remove('hidden');
                    fechaHoraInput.required = true;
                    // Asegúrate de que los otros campos de tiempo no estén requeridos si cambias de tipo
                    horaInicioInput.required = false;
                    fechaInicioInput.required = false;
                    diaMesInput.required = false;

                } else if (frecuencia === 'semanal') {
                    diasSemanaContainer.classList.remove('hidden');
                    horaClaseContainer.classList.remove('hidden');
                    fechaInicioContainer.classList.remove('hidden');

                    horaInicioInput.required = true;
                    fechaInicioInput.required = true;
                    // Desactivar campos de otros tipos
                    fechaHoraInput.required = false;
                    diaMesInput.required = false;

                } else if (frecuencia === 'mensual') {
                    diaMesContainer.classList.remove('hidden');
                    horaClaseContainer.classList.remove('hidden');
                    fechaInicioContainer.classList.remove('hidden');

                    diaMesInput.required = true;
                    horaInicioInput.required = true;
                    fechaInicioInput.required = true;
                    // Desactivar campos de otros tipos
                    fechaHoraInput.required = false;
                }
            }

            document.addEventListener('DOMContentLoaded', function() {
                handleFrecuenciaChange();
            });
        </script>
    @endpush
</x-app-layout>