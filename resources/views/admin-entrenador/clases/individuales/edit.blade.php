<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            Editar Clase Individual
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-gray-800 p-6 rounded-lg shadow">
            <form action="{{ route('admin-entrenador.clases-individuales.update', $claseIndividual) }}" method="POST"
                x-data="{
                    frecuencia: '{{ old('frecuencia', $claseIndividual->frecuencia ?? 'dia') }}',
                    fechaInicio: '{{ old('fecha_inicio', $claseIndividual->fecha_inicio) }}'
                }">
                @csrf
                @method('PUT')

                {{-- Título --}}
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Título</label>
                    <input type="text" name="titulo" required
                        value="{{ old('titulo', $claseIndividual->titulo) }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" rows="3"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">{{ old('descripcion', $claseIndividual->descripcion) }}</textarea>
                </div>

                {{-- Cliente --}}
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Cliente</label>
                    <select name="usuario_id" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('usuario_id', $claseIndividual->usuario_id) == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->name }} ({{ $cliente->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Entrenador --}}
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Entrenador</label>
                    <select name="entrenador_id"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
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
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Lugar</label>
                    <select name="lugar" id="lugar" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="" disabled {{ old('lugar') == '' ? 'selected' : '' }}>
                            Seleccionar Sala/Zona
                        </option>
                        <option value="Sala Principal" {{ old('lugar') == 'Sala Principal' ? 'selected' : '' }}>
                            Sala Principal
                        </option>
                        <option value="Sala de Spinning" {{ old('lugar') == 'Sala de Spinning' ? 'selected' : '' }}>
                            Sala de Spinning
                        </option>
                        <option value="Zona de Yoga" {{ old('lugar') == 'Zona de Yoga' ? 'selected' : '' }}>Zona de Yoga
                        </option>
                        <option value="Sala de Pesas" {{ old('lugar') == 'Sala de Pesas' ? 'selected' : '' }}>Sala de Pesas
                        </option>
                    </select>
                </div>

                {{-- Nivel --}}
                @php
                    $niveles = ['Básico', 'Intermedio', 'Avanzado'];
                @endphp
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Nivel</label>
                    <select name="nivel"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
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
                <div class="mb-4">
                    <label class="block text-white font-semibold mb-2">Frecuencia</label>
                    <select name="frecuencia" x-model="frecuencia"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        <option value="dia">Una sola vez</option>
                        <option value="semana">Semanal</option>
                        <option value="mes">Mensual</option>
                    </select>
                </div>

                {{-- Fecha y hora (para frecuencia dia) --}}
                <div class="mb-4" x-show="frecuencia === 'dia'" x-cloak>
                    <label class="block text-white font-semibold mb-2">Fecha y Hora</label>
                    <input type="datetime-local" name="fecha_hora"
                        value="{{ old('fecha_hora', optional($claseIndividual->fecha_hora)->format('Y-m-d\TH:i')) }}"
                        min="{{ optional($claseIndividual->fecha_hora)->format('Y-m-d\TH:i') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                </div>

                {{-- Fecha inicio / fin, hora y duración (para frecuencia semana o mes) --}}
                <div x-show="frecuencia !== 'dia'" x-cloak>
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" x-model="fechaInicio"
                            value="{{ old('fecha_inicio', $claseIndividual->fecha_inicio) }}"
                            min="{{ $claseIndividual->fecha_inicio }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Fecha de fin</label>
                        <input type="date" name="fecha_fin"
                            :min="fechaInicio"
                            value="{{ old('fecha_fin', $claseIndividual->fecha_fin) }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Hora de inicio</label>
                        <input type="time" name="hora_inicio"
                            value="{{ old('hora_inicio', $claseIndividual->hora_inicio) }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Duración (minutos)</label>
                        <input type="number" name="duracion"
                            value="{{ old('duracion', $claseIndividual->duracion) }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>
                </div>

                {{-- Días de la semana (solo si frecuencia es semana) --}}
                <div class="mb-4" x-show="frecuencia === 'semana'" x-cloak>
                    <label class="block text-white font-semibold mb-2">Días de la semana</label>
                    @php
                        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                        $seleccionados = old('dias_semana', json_decode($claseIndividual->dias_semana ?? '[]', true));
                    @endphp
                    <div class="flex flex-wrap gap-3">
                        @foreach ($diasSemana as $dia)
                            <label class="inline-flex items-center text-white">
                                <input type="checkbox" name="dias_semana[]" value="{{ $dia }}"
                                    class="form-checkbox text-red-500 bg-gray-700 border-gray-600 rounded"
                                    {{ in_array($dia, $seleccionados) ? 'checked' : '' }}>
                                <span class="ml-2">{{ $dia }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Día del mes (solo si frecuencia es mes) --}}
                <div class="mb-4" x-show="frecuencia === 'mes'" x-cloak>
                    <label class="block text-white font-semibold mb-2">Día del mes (1–31)</label>
                    @php
                        $diaMes = old('dias_semana.0', json_decode($claseIndividual->dias_semana ?? '[1]')[0]);
                    @endphp
                    <select name="dias_semana[]" class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}" {{ $diaMes == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                {{-- Botón de enviar --}}
                <div class="mt-6">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Actualizar clase
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
