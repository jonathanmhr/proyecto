<x-app-layout>
    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Encabezado de la Página: Título Principal y Botón Volver (FUERA de la tarjeta) --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 px-4 sm:px-0">
                <h2 class="font-extrabold text-4xl lg:text-5xl text-gray-800 dark:text-gray-100 leading-tight mb-4 sm:mb-0">
                    Editar Clase Individual: <span class="text-indigo-700 dark:text-indigo-400 block sm:inline-block mt-2 sm:mt-0">{{ $claseIndividual->titulo }}</span>
                </h2>
                <a href="{{ route('entrenador.clases.index') }}"
                    class="inline-flex items-center px-7 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl">
                    <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H16a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Volver a Clases
                </a>
            </div>

            {{-- La TARJETA PRINCIPAL con el formulario --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl p-10 lg:p-12 border border-gray-200 dark:border-gray-700">

                {{-- Mensaje de error de la sesión --}}
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg shadow-sm font-medium">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('entrenador.clases-individuales.update', ['claseIndividual' => $claseIndividual->id]) }}">
                    @csrf
                    @method('PUT')

                    <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8 text-center pb-4 border-b border-gray-200 dark:border-gray-700">Formulario de Edición</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-6">

                        {{-- Campo Título --}}
                        <div>
                            <label for="titulo" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Título</label>
                            <input id="titulo" name="titulo" type="text" value="{{ old('titulo', $claseIndividual->titulo) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('titulo') border-red-500 ring-red-500 @enderror">
                            @error('titulo')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Descripción --}}
                        <div class="md:col-span-2"> {{-- Ocupa las dos columnas en pantallas medianas --}}
                            <label for="descripcion" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Descripción</label>
                            <textarea id="descripcion" name="descripcion" rows="4"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('descripcion') border-red-500 ring-red-500 @enderror">{{ old('descripcion', $claseIndividual->descripcion) }}</textarea>
                            @error('descripcion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Cliente --}}
                        <div>
                            <label for="usuario_id" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Cliente</label>
                            <select id="usuario_id" name="usuario_id"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('usuario_id') border-red-500 ring-red-500 @enderror">
                                <option value="">Seleccione un cliente</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}"
                                        {{ old('usuario_id', $claseIndividual->usuario_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('usuario_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Frecuencia --}}
                        <div>
                            <label for="frecuencia" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Frecuencia</label>
                            <select id="frecuencia" name="frecuencia"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('frecuencia') border-red-500 ring-red-500 @enderror">
                                @php
                                    $freqs = ['dia' => 'Día', 'semana' => 'Semana', 'mes' => 'Mes'];
                                @endphp
                                @foreach ($freqs as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ old('frecuencia', $claseIndividual->frecuencia) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('frecuencia')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campos condicionales para Fechas y Horas --}}
                        {{-- Estos contenedores serán controlados por JavaScript --}}
                        <div id="fecha_hora_container" class="transition-all duration-300 ease-in-out">
                            <label for="fecha_hora" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Fecha y Hora</label>
                            <input id="fecha_hora" name="fecha_hora" type="datetime-local"
                                value="{{ old('fecha_hora', optional($claseIndividual->fecha_hora)->format('Y-m-d\TH:i')) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('fecha_hora') border-red-500 ring-red-500 @enderror">
                            @error('fecha_hora')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="fechas_rango_container" class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 transition-all duration-300 ease-in-out md:col-span-2">
                            <div>
                                <label for="fecha_inicio" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Fecha Inicio</label>
                                <input id="fecha_inicio" name="fecha_inicio" type="date"
                                    value="{{ old('fecha_inicio', optional($claseIndividual->fecha_inicio)->format('Y-m-d')) }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('fecha_inicio') border-red-500 ring-red-500 @enderror">
                                @error('fecha_inicio')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="fecha_fin" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Fecha Fin</label>
                                <input id="fecha_fin" name="fecha_fin" type="date"
                                    value="{{ old('fecha_fin', optional($claseIndividual->fecha_fin)->format('Y-m-d')) }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('fecha_fin') border-red-500 ring-red-500 @enderror">
                                @error('fecha_fin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div id="dias_semana_container" class="transition-all duration-300 ease-in-out">
                            <label for="dias_semana" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Días de la Semana (Separados por comas)</label>
                            <input id="dias_semana" name="dias_semana" type="text"
                                value="{{ old('dias_semana', $claseIndividual->dias_semana) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('dias_semana') border-red-500 ring-red-500 @enderror"
                                placeholder="Ej: Lunes, Miércoles, Viernes">
                            @error('dias_semana')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div id="hora_inicio_container" class="transition-all duration-300 ease-in-out">
                            <label for="hora_inicio" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Hora de Inicio</label>
                            <input id="hora_inicio" name="hora_inicio" type="time"
                                value="{{ old('hora_inicio', optional($claseIndividual->hora_inicio)->format('H:i')) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('hora_inicio') border-red-500 ring-red-500 @enderror">
                            @error('hora_inicio')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Duración --}}
                        <div>
                            <label for="duracion" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Duración (minutos)</label>
                            <input id="duracion" name="duracion" type="number" min="1"
                                value="{{ old('duracion', $claseIndividual->duracion) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('duracion') border-red-500 ring-red-500 @enderror">
                            @error('duracion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Lugar --}}
                        <div>
                            <label for="lugar" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Lugar</label>
                            <input id="lugar" name="lugar" type="text"
                                value="{{ old('lugar', $claseIndividual->lugar) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('lugar') border-red-500 ring-red-500 @enderror">
                            @error('lugar')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Campo Nivel --}}
                        <div>
                            <label for="nivel" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Nivel</label>
                            <input id="nivel" name="nivel" type="text"
                                value="{{ old('nivel', $claseIndividual->nivel) }}"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('nivel') border-red-500 ring-red-500 @enderror">
                            @error('nivel')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Botones de acción del formulario --}}
                    <div class="flex justify-end gap-6 mt-12 pt-8 border-t-2 border-gray-200 dark:border-gray-700">
                        <a href="{{ route('entrenador.clases.index') }}"
                           class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-semibold rounded-lg shadow-lg text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl">
                            <svg class="-ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H16a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Cancelar
                        </a>

                        <button type="submit"
                                class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-semibold rounded-lg shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl">
                            <svg class="-ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path d="M5.477 15.545A.75.75 0 014 15V5a.75.75 0 011.23-.585l7.5 5a.75.75 0 010 1.17l-7.5 5.001a.75.75 0 01-.75-.021z" />
                            </svg>
                            Enviar Solicitud de Modificación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const frecuenciaSelect = document.getElementById('frecuencia');
            const fechaHoraContainer = document.getElementById('fecha_hora_container');
            const fechasRangoContainer = document.getElementById('fechas_rango_container');
            const diasSemanaContainer = document.getElementById('dias_semana_container');
            const horaInicioContainer = document.getElementById('hora_inicio_container');

            function toggleConditionalFields() {
                const frecuencia = frecuenciaSelect.value;

                // Ocultar todos los contenedores por defecto
                fechaHoraContainer.style.display = 'none';
                fechasRangoContainer.style.display = 'none';
                diasSemanaContainer.style.display = 'none';
                horaInicioContainer.style.display = 'none';

                // Mostrar los campos relevantes según la frecuencia
                if (frecuencia === 'dia') {
                    fechaHoraContainer.style.display = 'block';
                } else if (frecuencia === 'semana' || frecuencia === 'mes') {
                    fechasRangoContainer.style.display = 'grid'; // Usar 'grid' ya que es un grid de 2 columnas
                    diasSemanaContainer.style.display = 'block';
                    horaInicioContainer.style.display = 'block';
                }
            }

            // Llamar al inicio para establecer el estado correcto basado en el valor actual
            toggleConditionalFields();

            // Escuchar cambios en el selector de frecuencia
            frecuenciaSelect.addEventListener('change', toggleConditionalFields);
        });
    </script>
</x-app-layout>