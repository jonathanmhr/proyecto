<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-8">

                {{-- Título y botón volver --}}
                <div class="flex justify-between items-center mb-10 pb-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-200 leading-tight">
                        Detalle de Clase Grupal: <span class="text-indigo-600 dark:text-indigo-400">{{ $clase->nombre }}</span>
                    </h2>
                    <a href="{{ route('entrenador.clases.index') }}"
                        class="inline-flex items-center px-5 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-150">
                        <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H16a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Volver a Clases
                    </a>
                </div>

                {{-- Información de la clase --}}
                <section class="mb-10 border-b pb-8 border-gray-200 dark:border-gray-700">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Información General</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-lg text-gray-700 dark:text-gray-300">
                        <div>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Descripción:</strong> {{ $clase->descripcion ?? 'Sin descripción detallada.' }}</p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Ubicación:</strong> {{ $clase->ubicacion ?? 'No especificada' }}</p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Nivel:</strong> <span class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200">{{ ucfirst($clase->nivel ?? 'No especificado') }}</span></p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Cupos Máximos:</strong> {{ $clase->cupos_maximos }}</p>
                        </div>
                        <div>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Fecha Inicio:</strong> <span class="font-medium">{{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}</span></p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Fecha Fin:</strong> <span class="font-medium">{{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}</span></p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Hora Inicio:</strong> <span class="font-medium">{{ \Carbon\Carbon::parse($clase->hora_inicio)->format('H:i') }}</span></p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Duración:</strong> {{ $clase->duracion ? $clase->duracion . ' minutos' : 'No especificada' }}</p>
                            <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Frecuencia:</strong> {{ ucfirst($clase->frecuencia) }}</p>
                            @if($clase->dias_semana)
                                <p class="mb-2"><strong class="text-gray-900 dark:text-gray-100">Días de la Semana:</strong> {{ implode(', ', $clase->dias_semana) }}</p>
                            @endif
                        </div>
                    </div>
                </section>

                {{-- Lista de alumnos aprobados --}}
                <section class="mb-10">
                    <h3 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Alumnos Inscritos (<span class="text-indigo-600 dark:text-indigo-400">{{ $alumnos->count() }}</span>)</h3>

                    @if($alumnos->isEmpty())
                        <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-md text-gray-600 dark:text-gray-400 text-center shadow-inner">
                            <p class="text-lg">No hay alumnos inscritos en esta clase aún. ¡Anima a tus alumnos a unirse!</p>
                        </div>
                    @else
                        <div class="overflow-x-auto shadow-md sm:rounded-lg border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Nombre Completo
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Correo Electrónico
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($alumnos as $alumno)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-900 transition duration-150 ease-in-out">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $alumno->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                {{ $alumno->email }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </section>
            </div>
        </div>
    </div>
</x-app-layout>