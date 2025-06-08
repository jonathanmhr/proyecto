<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            Crear Clase Individual
        </h2>
    </x-slot>

    @if ($errors->any())
        <div class="bg-red-200 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li class="text-red-700">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-gray-800 p-6 rounded-lg shadow">
            <form method="POST" action="{{ route('admin-entrenador.clases-individuales.store') }}"
                x-data="{ frecuencia: '{{ old('frecuencia', 'unica') }}' }">
                @csrf

                {{-- Título --}}
                <div class="mb-4">
                    <label for="titulo" class="block text-white font-semibold mb-2">Título</label>
                    <input type="text" name="titulo" id="titulo" required value="{{ old('titulo') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>

                {{-- Descripción --}}
                <div class="mb-4">
                    <label for="descripcion" class="block text-white font-semibold mb-2">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500">{{ old('descripcion') }}</textarea>
                </div>

                {{-- Cliente --}}
                <div class="mb-4">
                    <label for="usuario_id" class="block text-white font-semibold mb-2">Cliente</label>
                    <select name="usuario_id" id="usuario_id" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        <option value="" disabled {{ old('usuario_id') ? '' : 'selected' }}>Seleccionar Cliente
                        </option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}"
                                {{ old('usuario_id') == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->name }} ({{ $cliente->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nivel --}}
                <div class="mb-4">
                    <label for="nivel" class="block text-white font-semibold mb-2">Nivel de Clase</label>
                    <select name="nivel" id="nivel" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="" disabled {{ old('nivel') == '' ? 'selected' : '' }}>
                            Seleccionar nivel</option>
                        <option value="principiante" {{ old('nivel') == 'principiante' ? 'selected' : '' }}>
                            Principiante
                        </option>
                        <option value="intermedio" {{ old('nivel') == 'intermedio' ? 'selected' : '' }}>
                            Intermedio</option>
                        <option value="avanzado" {{ old('nivel') == 'avanzado' ? 'selected' : '' }}>
                            Avanzado</option>
                        <option value="todos" {{ old('nivel') == 'todos' ? 'selected' : '' }}>Todos los niveles
                        </option>
                    </select>
                </div>

                {{-- Entrenador --}}
                <div class="mb-4">
                    <label for="entrenador_id" class="block text-white font-semibold mb-2">Entrenador</label>
                    <select name="entrenador_id" id="entrenador_id" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        <option value="" disabled {{ old('entrenador_id') ? '' : 'selected' }}>Seleccionar
                            Entrenador</option>
                        @foreach ($entrenadores as $entrenador)
                            <option value="{{ $entrenador->id }}"
                                {{ old('entrenador_id') == $entrenador->id ? 'selected' : '' }}>
                                {{ $entrenador->name }} ({{ $entrenador->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Frecuencia --}}
                <div class="mb-4">
                    <label for="frecuencia" class="block text-white font-semibold mb-2">Frecuencia</label>
                    <select name="frecuencia" id="frecuencia" x-model="frecuencia"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        <option value="" disabled>Selecciona una frecuencia</option>
                        <option value="unica" {{ old('frecuencia') == 'unica' ? 'selected' : '' }}>Una sola vez
                        </option>
                        <option value="semanal" {{ old('frecuencia') == 'semanal' ? 'selected' : '' }}>Semanal</option>
                        <option value="mensual" {{ old('frecuencia') == 'mensual' ? 'selected' : '' }}>Mensual</option>
                    </select>
                </div>

                {{-- Campo único: fecha_hora (cuando frecuencia es "unica") --}}
                <div class="mb-4" x-show="frecuencia === 'unica'" x-cloak>
                    <label for="fecha_hora" class="block text-white font-semibold mb-2">Fecha y Hora</label>
                    <input type="datetime-local" name="fecha_hora" id="fecha_hora" value="{{ old('fecha_hora') }}"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                </div>

                {{-- Campos para "semanal" o "mensual" --}}
                <div x-show="frecuencia !== 'unica' && frecuencia !== ''" x-cloak>
                    {{-- Rango de fechas --}}
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Fecha de inicio</label>
                        <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Fecha de fin</label>
                        <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>

                    {{-- Hora de inicio --}}
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Hora de inicio</label>
                        <input type="time" name="hora_inicio" value="{{ old('hora_inicio') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>

                    {{-- Duración --}}
                    <div class="mb-4">
                        <label class="block text-white font-semibold mb-2">Duración (minutos)</label>
                        <input type="number" name="duracion" min="1" value="{{ old('duracion') }}"
                            class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                    </div>
                </div>

                {{-- Días de la semana (solo si frecuencia = semanal) --}}
                <div class="mb-4" x-show="frecuencia === 'semanal'" x-cloak>
                    <label class="block text-white font-semibold mb-2">Días de la semana</label>
                    @php
                        $dias = ['lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo'];
                    @endphp
                    <div class="flex flex-wrap gap-3">
                        @foreach ($dias as $dia)
                            <label class="inline-flex items-center text-white">
                                <input type="checkbox" name="dias_semana[]" value="{{ $dia }}"
                                    class="form-checkbox text-red-500 bg-gray-700 border-gray-600 rounded"
                                    {{ is_array(old('dias_semana')) && in_array($dia, old('dias_semana')) ? 'checked' : '' }}>
                                <span class="ml-2 capitalize">{{ $dia }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- Días del mes (solo si frecuencia = mensual) --}}
                <div class="mb-4" x-show="frecuencia === 'mensual'" x-cloak>
                    <label class="block text-white font-semibold mb-2">Día del mes</label>
                    <select name="dias_mes"
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg">
                        @for ($i = 1; $i <= 31; $i++)
                            <option value="{{ $i }}" {{ old('dias_mes') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                {{-- Lugar --}}
                <div class="mb-4">
                    <label for="lugar" class="block text-white font-semibold mb-2">Lugar</label>
                    <select name="lugar" id="lugar" required
                        class="w-full p-3 bg-gray-700 text-white border border-gray-600 rounded-lg focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition duration-200 appearance-none">
                        <option value="" disabled {{ old('lugar') == '' ? 'selected' : '' }}>
                            Seleccionar Sala/Zona</option>
                        <option value="Sala Principal" {{ old('lugar') == 'Sala Principal' ? 'selected' : '' }}>
                            Sala Principal
                        </option>
                        <option value="Sala de Spinning" {{ old('lugar') == 'Sala de Spinning' ? 'selected' : '' }}>
                            Sala de Spinning
                        </option>
                        <option value="Zona de Yoga" {{ old('lugar') == 'Zona de Yoga' ? 'selected' : '' }}>Zona
                            de Yoga
                        </option>
                        <option value="Sala de Pesas" {{ old('lugar') == 'Sala de Pesas' ? 'selected' : '' }}>Sala
                            de Pesas
                        </option>
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                        Crear clase
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
