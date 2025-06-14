<x-app-layout>
    {{-- Contenedor principal con gradiente de fondo para un look moderno --}}
    <div class="py-12 bg-gradient-to-br from-indigo-50 to-purple-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Encabezado de la página --}}
            <x-slot name="header">
                <h2 class="font-extrabold text-5xl text-gray-800 dark:text-gray-100 leading-tight text-center mb-8">
                    {{ __('Crear Perfil de Instructor') }}
                </h2>
            </x-slot>

            {{-- Contenedor principal del formulario --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl p-8 lg:p-10 border border-gray-200 dark:border-gray-700 transform hover:scale-[1.005] transition duration-300 ease-in-out">

                {{-- Mensajes de error de validación --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-lg shadow-sm font-medium border border-red-400 dark:border-red-700">
                        <div class="flex items-center mb-2">
                            <svg class="h-6 w-6 text-red-500 dark:text-red-300 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                            <h3 class="text-xl font-bold">¡Errores de Validación!</h3>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('entrenador.profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    {{-- Sección de Información Personal --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Datos Personales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Campo Nombre (Solo Lectura) --}}
                            <div>
                                <label for="nombre" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Nombre <span class="text-red-500">*</span></label>
                                <input type="text" name="nombre" id="nombre" value="{{ old('nombre', $user->name ?? '') }}" required readonly
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed" />
                                @error('nombre')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Campo Apellidos (Editable) --}}
                            <div>
                                <label for="apellidos" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Apellidos</label>
                                <input type="text" name="apellidos" id="apellidos" value="{{ old('apellidos') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('apellidos') border-red-500 ring-red-500 @enderror" />
                                @error('apellidos')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Campo Email (Solo Lectura) --}}
                            <div>
                                <label for="email" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email ?? '') }}" required readonly
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed" />
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Campo Especialidad (Editable) --}}
                            <div>
                                <label for="especialidad" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Especialidad</label>
                                <input type="text" name="especialidad" id="especialidad" value="{{ old('especialidad') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('especialidad') border-red-500 ring-red-500 @enderror" />
                                @error('especialidad')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Campo Teléfono (Editable) --}}
                            <div>
                                <label for="telefono" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Teléfono</label>
                                <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('telefono') border-red-500 ring-red-500 @enderror" />
                                @error('telefono')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección de Horario de Disponibilidad --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Horario de Disponibilidad</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Días de la Semana <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-3 text-lg">
                                    @php
                                        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
                                        $oldDias = old('dias', []); // Obtiene los días seleccionados previamente, o un array vacío
                                    @endphp
                                    @foreach ($diasSemana as $dia)
                                        <label class="flex items-center space-x-2 text-gray-800 dark:text-gray-200">
                                            <input type="checkbox" name="dias[]" value="{{ $dia }}"
                                                class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 dark:text-indigo-500 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600"
                                                {{ in_array($dia, $oldDias) ? 'checked' : '' }}>
                                            <span>{{ $dia }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('dias')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                                @error('dias.*')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hora_inicio" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Hora de Inicio <span class="text-red-500">*</span></label>
                                <input type="time" name="hora_inicio" id="hora_inicio" value="{{ old('hora_inicio') }}" required
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('hora_inicio') border-red-500 ring-red-500 @enderror" />
                                @error('hora_inicio')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hora_fin" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Hora de Fin <span class="text-red-500">*</span></label>
                                <input type="time" name="hora_fin" id="hora_fin" value="{{ old('hora_fin') }}" required
                                    class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('hora_fin') border-red-500 ring-red-500 @enderror" />
                                @error('hora_fin')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Sección de Detalles Adicionales --}}
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Información Adicional</h3>
                        <div>
                            <label for="descripcion" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="5"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('descripcion') border-red-500 ring-red-500 @enderror">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="certificaciones" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Certificaciones</label>
                            <textarea name="certificaciones" id="certificaciones" rows="4"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('certificaciones') border-red-500 ring-red-500 @enderror">{{ old('certificaciones') }}</textarea>
                            @error('certificaciones')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mt-6">
                            <label for="foto" class="block text-lg font-medium text-gray-800 dark:text-gray-200 mb-2">Foto de Perfil (opcional)</label>
                            <input type="file" name="foto" id="foto" accept="image/*"
                                class="w-full text-white file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100 cursor-pointer
                                dark:file:bg-indigo-900 dark:file:text-indigo-200 dark:hover:file:bg-indigo-800" />
                            @error('foto')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-6 mt-10 pt-8">
                        <a href="{{ route('entrenador.dashboard') }}"
                           class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-full shadow-lg text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto">
                            <svg class="-ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H16a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Volver al Dashboard
                        </a>

                        <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-semibold rounded-full shadow-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto">
                            <svg class="-ml-1 mr-3 h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Crear Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>