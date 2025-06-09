<x-app-layout>
    {{-- El header slot se puede mantener para otros elementos globales si es necesario,
         o se puede vaciar si el título y botón se manejan directamente aquí. --}}
    <x-slot name="header"></x-slot>

    {{-- Sección superior con título y botón de volver --}}
    <div class="bg-gray-900 shadow-md py-4 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center max-w-7xl mx-auto">
            <h2 class="text-3xl font-extrabold leading-tight text-white">
                Editar Clase: <span class="text-red-500"> Individual </span>
            </h2>
            <a href="{{ route('admin-entrenador.clases.index') }}"
                class="inline-flex items-center px-5 py-2 bg-blue-700 text-white font-semibold rounded-full shadow-lg hover:bg-blue-800 transition duration-300 ease-in-out transform hover:scale-105">
                <i data-feather="arrow-left" class="w-5 h-5 mr-2"></i>
                Volver al listado
            </a>
        </div>
    </div>

    <div class="py-8"> {{-- Aumentado el padding vertical para más espacio --}}
        <div class="max-w-4xl mx-auto bg-gray-800 p-8 rounded-xl shadow-lg border border-gray-700"> {{-- Más padding, bordes redondeados y sombra --}}
            <form action="{{ route('admin-entrenador.clases-individuales.update', $claseIndividual) }}" method="POST"
                x-data="{
                    frecuencia: '{{ old('frecuencia', $claseIndividual->frecuencia ?? 'dia') }}',
                    fechaInicio: '{{ old('fecha_inicio', $claseIndividual->fecha_inicio) }}'
                }">
                @csrf
                @method('PUT')

                {{-- Campos del formulario --}}
                <div class="space-y-6"> {{-- Agrupados los campos con espaciado consistente --}}

                    {{-- Título --}}
                    <div>
                        <label for="titulo" class="block text-white font-semibold mb-2 text-lg">Título</label>
                        <input type="text" name="titulo" id="titulo" required
                            value="{{ old('titulo', $claseIndividual->titulo) }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="descripcion" class="block text-white font-semibold mb-2 text-lg">Descripción</label>
                        <textarea name="descripcion" id="descripcion" rows="4"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">{{ old('descripcion', $claseIndividual->descripcion) }}</textarea>
                    </div>

                    {{-- Cliente --}}
                    <div>
                        <label for="usuario_id" class="block text-white font-semibold mb-2 text-lg">Cliente</label>
                        <select name="usuario_id" id="usuario_id" required
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}"
                                    {{ old('usuario_id', $claseIndividual->usuario_id) == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->name }} ({{ $cliente->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Entrenador --}}
                    <div>
                        <label for="entrenador_id" class="block text-white font-semibold mb-2 text-lg">Entrenador</label>
                        <select name="entrenador_id" id="entrenador_id"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                            <option value="">-- Seleccione entrenador --</option>
                            @foreach ($entrenadores as $entrenador)
                                <option value="{{ $entrenador->id }}"
                                    {{ old('entrenador_id', $claseIndividual->entrenador_id) == $entrenador->id ? 'selected' : '' }}>
                                    {{ $entrenador->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Lugar --}}
                    <div>
                        <label for="lugar" class="block text-white font-semibold mb-2 text-lg">Lugar</label>
                        <select name="lugar" id="lugar" required
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200 appearance-none">
                            <option value="" disabled {{ old('lugar') == '' ? 'selected' : '' }}>
                                Seleccionar Sala/Zona
                            </option>
                            <option value="Sala Principal" {{ old('lugar') == 'Sala Principal' ? 'selected' : '' }}>
                                Sala Principal
                            </option>
                            <option value="Sala de Spinning" {{ old('lugar') == 'Sala de Spinning' ? 'selected' : '' }}>
                                Sala de Spinning
                            </option>
                            <option value="Zona de Yoga" {{ old('lugar') == 'Zona de Yoga' ? 'selected' : '' }}>Zona de
                                Yoga
                            </option>
                            <option value="Sala de Pesas" {{ old('lugar') == 'Sala de Pesas' ? 'selected' : '' }}>Sala de
                                Pesas
                            </option>
                        </select>
                    </div>

                    {{-- Nivel --}}
                    @php
                        $niveles = ['Básico', 'Intermedio', 'Avanzado'];
                    @endphp
                    <div>
                        <label for="nivel" class="block text-white font-semibold mb-2 text-lg">Nivel</label>
                        <select name="nivel" id="nivel" class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                            <option value="">Seleccione nivel</option>
                            @foreach ($niveles as $nivel)
                                <option value="{{ $nivel }}"
                                    {{ old('nivel', $claseIndividual->nivel) == $nivel ? 'selected' : '' }}>
                                    {{ $nivel }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Frecuencia --}}
                    <div>
                        <label for="frecuencia" class="block text-white font-semibold mb-2 text-lg">Frecuencia</label>
                        <select name="frecuencia" id="frecuencia" x-model="frecuencia"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                            <option value="dia">Una sola vez</option>
                            <option value="semana">Semanal</option>
                            <option value="mes">Mensual</option>
                        </select>
                    </div>

                    {{-- Fecha y hora (para frecuencia dia) --}}
                    <div x-show="frecuencia === 'dia'" x-cloak>
                        <label for="fecha_hora" class="block text-white font-semibold mb-2 text-lg">Fecha y Hora</label>
                        <input type="datetime-local" name="fecha_hora" id="fecha_hora"
                            value="{{ old('fecha_hora', optional($claseIndividual->fecha_hora)->format('Y-m-d\TH:i')) }}"
                            min="{{ optional($claseIndividual->fecha_hora)->format('Y-m-d\TH:i') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                    </div>

                    {{-- Fecha inicio / fin, hora y duración (para frecuencia semana o mes) --}}
                    <div x-show="frecuencia !== 'dia'" x-cloak class="space-y-6">
                        <div>
                            <label for="fecha_inicio" class="block text-white font-semibold mb-2 text-lg">Fecha de inicio</label>
                            <input type="date" name="fecha_inicio" id="fecha_inicio" x-model="fechaInicio"
                                value="{{ old('fecha_inicio', $claseIndividual->fecha_inicio) }}"
                                min="{{ $claseIndividual->fecha_inicio }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        </div>
                        <div>
                            <label for="fecha_fin" class="block text-white font-semibold mb-2 text-lg">Fecha de fin</label>
                            <input type="date" name="fecha_fin" id="fecha_fin" :min="fechaInicio"
                                value="{{ old('fecha_fin', $claseIndividual->fecha_fin) }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        </div>
                        <div>
                            <label for="hora_inicio" class="block text-white font-semibold mb-2 text-lg">Hora de inicio</label>
                            <input type="time" name="hora_inicio" id="hora_inicio"
                                value="{{ old('hora_inicio', $claseIndividual->hora_inicio) }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        </div>
                        <div>
                            <label for="duracion" class="block text-white font-semibold mb-2 text-lg">Duración (minutos)</label>
                            <input type="number" name="duracion" id="duracion" value="{{ old('duracion', $claseIndividual->duracion) }}"
                                class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                        </div>
                    </div>

                    {{-- Días de la semana (solo si frecuencia es semana) --}}
                    <div x-show="frecuencia === 'semana'" x-cloak>
                        <label class="block text-white font-semibold mb-2 text-lg">Días de la semana</label>
                        @php
                            $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                            $seleccionados = old('dias_semana', json_decode($claseIndividual->dias_semana ?? '[]', true));
                        @endphp
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                            @foreach ($diasSemana as $dia)
                                <label class="inline-flex items-center text-white cursor-pointer hover:text-blue-300 transition duration-200">
                                    <input type="checkbox" name="dias_semana[]" value="{{ $dia }}"
                                        class="form-checkbox h-5 w-5 text-red-500 bg-gray-700 border-gray-600 rounded focus:ring-red-500"
                                        {{ in_array($dia, $seleccionados) ? 'checked' : '' }}>
                                    <span class="ml-2 text-base">{{ $dia }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Día del mes (solo si frecuencia es mes) --}}
                    <div x-show="frecuencia === 'mes'" x-cloak>
                        <label for="dia_mes" class="block text-white font-semibold mb-2 text-lg">Día del mes (1–31)</label>
                        @php
                            $diaMes = old('dias_semana.0', json_decode($claseIndividual->dias_semana ?? '[1]')[0]);
                        @endphp
                        <select name="dias_semana[]" id="dia_mes"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition duration-200">
                            @for ($i = 1; $i <= 31; $i++)
                                <option value="{{ $i }}" {{ $diaMes == $i ? 'selected' : '' }}>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                </div> {{-- Fin de space-y-6 --}}

                {{-- Botón de enviar --}}
                <div class="mt-8 text-center"> {{-- Centrado y con más margen superior --}}
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75">
                        Actualizar clase
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>