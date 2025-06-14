<x-app-layout>
    {{-- Contenedor principal con gradiente de fondo para un look moderno y suave --}}
    {{-- Aumentado ligeramente el max-w a 'max-w-4xl' para evitar que el contenido se corte, manteniendo el estilo. --}}
    <div class="py-10 bg-gradient-to-br from-indigo-50 to-purple-100 dark:from-gray-900 dark:to-gray-800 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje si el perfil de instructor no existe --}}
            @if (!$instructor)
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900 dark:to-yellow-800 border border-yellow-300 dark:border-yellow-700 text-yellow-800 dark:text-yellow-200 px-5 py-5 rounded-xl shadow-lg mb-8 text-center transform hover:scale-[1.005] transition duration-300 ease-in-out"
                    role="alert">
                    <div class="flex flex-col items-center justify-center mb-4">
                        <svg class="h-10 w-10 text-yellow-600 dark:text-yellow-300 mb-3 animate-bounce"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8.257 3.099c.765-1.542 2.705-1.542 3.47 0l5.58 11.25A1.5 1.5 0 0117.373 17H2.627a1.5 1.5 0 01-1.359-2.15l5.58-11.25zM10 11a1 1 0 110-2 1 1 0 010 2zm1-1a1 1 0 10-2 0 1 1 0 002 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <h2 class="text-2xl font-extrabold text-yellow-900 dark:text-yellow-100 mb-2">¡Atención! Perfil
                            Incompleto</h2>
                    </div>
                    <p class="text-base leading-relaxed mb-5">Parece que aún no tienes un **perfil de instructor**
                        completo. Es **necesario** para gestionar tus clases y clientes de manera efectiva.</p>
                    <a href="{{ route('entrenador.profile.edit') }}"
                        class="inline-flex items-center px-5 py-2.5 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Completar/Editar mi Perfil
                    </a>
                </div>
            @else
                {{-- Encabezado de la página para el perfil existente --}}
                <x-slot name="header">
                    <h2 class="font-extrabold text-3xl text-gray-800 dark:text-gray-100 leading-tight text-center mb-5">
                        {{ __('Mi Perfil de Instructor') }}
                    </h2>
                </x-slot>

                {{-- Contenedor principal del perfil --}}
                <div
                    class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl p-6 lg:p-7 border border-gray-200 dark:border-gray-700 transform hover:scale-[1.005] transition duration-300 ease-in-out">

                    {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div
                            class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-lg shadow-md font-medium border border-green-400 dark:border-green-700 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-green-500 dark:text-green-300 mr-2" fill="currentColor"
                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>{{ session('success') }}</span>
                            </div>
                            <button type="button"
                                class="text-green-700 dark:text-green-300 hover:text-green-900 dark:hover:text-green-100"
                                onclick="this.closest('div').remove();">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        {{-- Sección de la Foto de Perfil --}}
                        <div class="flex-shrink-0 relative">
                            @if ($instructor->foto)
                                <img src="{{ asset('storage/' . $instructor->foto) }}"
                                    alt="Foto de {{ $instructor->nombre }}"
                                    class="w-40 h-40 rounded-full object-cover border-3 border-indigo-500 dark:border-indigo-600 shadow-md ring-2 ring-indigo-300 dark:ring-indigo-700 transition duration-300 ease-in-out hover:scale-105">
                            @else
                                <div
                                    class="w-40 h-40 rounded-full bg-indigo-600 dark:bg-indigo-700 flex items-center justify-center text-5xl font-bold text-indigo-100 dark:text-indigo-300 border-3 border-indigo-500 dark:border-indigo-600 shadow-md ring-2 ring-indigo-300 dark:ring-indigo-700 transition duration-300 ease-in-out hover:scale-105">
                                    {{ strtoupper(substr($instructor->nombre ?? '??', 0, 2)) }}
                                </div>
                            @endif
                            {{-- Indicador de estado Activo/Inactivo --}}
                            @if ($instructor->activo)
                                <span
                                    class="absolute bottom-3 right-3 block h-5 w-5 rounded-full bg-green-500 ring-2 ring-white dark:ring-gray-800"
                                    title="Activo"></span>
                            @else
                                <span
                                    class="absolute bottom-3 right-3 block h-5 w-5 rounded-full bg-red-500 ring-2 ring-white dark:ring-gray-800"
                                    title="Inactivo"></span>
                            @endif
                        </div>

                        {{-- Detalles del Instructor --}}
                        <div class="flex-grow text-gray-800 dark:text-gray-200 w-full md:w-auto">
                            <h3
                                class="text-3xl font-extrabold text-indigo-700 dark:text-indigo-400 mb-3 pb-2 border-b border-gray-200 dark:border-gray-700">
                                {{ $instructor->nombre ?? 'Nombre No Definido' }} {{ $instructor->apellidos ?? '' }}
                            </h3>

                            {{-- Aseguramos suficiente espacio para la segunda columna del grid --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5 gap-y-3 text-base">
                                <p><span class="font-semibold text-gray-900 dark:text-gray-100">Especialidad:</span>
                                    {{ $instructor->especialidad ?? 'No definida' }}</p>
                                <p class="flex items-center"><span
                                        class="font-semibold text-gray-900 dark:text-gray-100 mr-1.5">Email:</span>
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-1" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z">
                                        </path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                    {{ $instructor->email ?? 'No definido' }}
                                </p>
                                <p class="flex items-center"><span
                                        class="font-semibold text-gray-900 dark:text-gray-100 mr-1.5">Teléfono:</span>
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mr-1" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.774a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                                        </path>
                                    </svg>
                                    {{ $instructor->telefono ?? 'No definido' }}
                                </p>
                            </div>

                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                                <p class="font-bold text-gray-900 dark:text-gray-100 text-xl mb-3">Horario de
                                    Disponibilidad:</p>
                                @php
                                    $horarioData = $instructor->horario;
                                @endphp

                                @if ($horarioData && !empty($horarioData['dias']))
                                    <div class="mb-3">
                                        <p class="font-semibold text-gray-800 dark:text-gray-300 text-base mb-2">Días:
                                        </p>
                                        <ul
                                            class="flex flex-wrap gap-x-2.5 gap-y-1 text-base text-gray-700 dark:text-gray-300">
                                            @foreach ($horarioData['dias'] as $dia)
                                                <li
                                                    class="px-2 py-0.5 bg-indigo-100 dark:bg-indigo-700 rounded-full shadow-sm text-indigo-800 dark:text-indigo-200 text-sm">
                                                    {{ $dia }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="text-base">
                                        <p><span class="font-semibold text-gray-800 dark:text-gray-300">Horas:</span>
                                            {{ $horarioData['hora_inicio'] ?? 'N/A' }} a
                                            {{ $horarioData['hora_fin'] ?? 'N/A' }}</p>
                                    </div>
                                @else
                                    <p class="text-base text-gray-600 dark:text-gray-400">Horario no especificado.</p>
                                @endif
                            </div>

                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                                <p class="font-bold text-gray-900 dark:text-gray-100 text-xl mb-3">Descripción:</p>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-base">
                                    {!! nl2br(e($instructor->descripcion)) ?? 'No definida' !!}</p>
                            </div>

                            <div class="mt-6 border-t border-gray-200 dark:border-gray-700 pt-6">
                                <p class="font-bold text-gray-900 dark:text-gray-100 text-xl mb-3">Certificaciones:</p>
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-base">
                                    {!! nl2br(e($instructor->certificaciones)) ?? 'No definidas' !!}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Botones de acción --}}
                    <div
                        class="mt-8 pt-6 border-t-2 border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row justify-center gap-4">
                        <a href="{{ route('entrenador.dashboard') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto">
                            <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H16a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                            Volver al Dashboard
                        </a>

                        <a href="{{ route('entrenador.profile.edit') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl w-full sm:w-auto">
                            <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.828z">
                                </path>
                            </svg>
                            Editar Perfil
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
