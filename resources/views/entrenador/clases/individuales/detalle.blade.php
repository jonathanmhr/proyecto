<x-app-layout>
    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen"> {{-- Fondo más claro/oscuro para un contraste mejor --}}
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> {{-- Ancho máximo para un diseño amplio --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-2xl sm:rounded-xl p-10 lg:p-12 border border-gray-200 dark:border-gray-700"> {{-- Sombra pronunciada y padding generoso --}}

                {{-- Encabezado de la Página: Título y Botón Volver --}}
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-12 pb-6 border-b-2 border-indigo-200 dark:border-indigo-700"> {{-- Borde inferior temático y adaptable --}}
                    <h2 class="font-extrabold text-4xl lg:text-5xl text-gray-800 dark:text-gray-100 leading-tight mb-4 sm:mb-0">
                        Detalle de Clase Individual: <span class="text-indigo-700 dark:text-indigo-400 block sm:inline-block mt-2 sm:mt-0">{{ $clase->titulo }}</span>
                    </h2>
                    <a href="{{ route('entrenador.clases.index') }}"
                        class="inline-flex items-center px-7 py-3 border border-transparent text-base font-semibold rounded-full shadow-lg text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-gray-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl">
                        <svg class="-ml-1 mr-3 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H16a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                        Volver a Clases
                    </a>
                </div>

                {{-- Información de la clase individual --}}
                <section class="mb-12 border-b pb-8 border-gray-200 dark:border-gray-700"> {{-- Sección de información con borde inferior --}}
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-8 text-center">Información General</h3> {{-- Título de sección centrado --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-6 text-xl text-gray-700 dark:text-gray-300"> {{-- Diseño de 2 columnas con mayor espaciado --}}
                        <div>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Título:</strong> <span class="text-indigo-600 dark:text-indigo-300 font-medium">{{ $clase->titulo }}</span></p>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Descripción:</strong> {{ $clase->descripcion ?? 'Sin descripción detallada.' }}</p>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Cliente:</strong> <span class="font-medium text-blue-600 dark:text-blue-400">{{ $clase->usuario->name ?? 'No asignado' }}</span></p>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Entrenador:</strong> <span class="font-medium text-green-600 dark:text-green-400">{{ $clase->entrenador->name ?? 'No asignado' }}</span></p>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Lugar:</strong> {{ $clase->lugar ?? 'No especificado' }}</p>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Nivel:</strong> <span class="inline-flex items-center px-4 py-1.5 rounded-full text-lg font-bold bg-blue-200 text-blue-900 dark:bg-blue-800 dark:text-blue-200 shadow-sm">{{ ucfirst($clase->nivel ?? 'No especificado') }}</span></p>
                        </div>
                        <div>
                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Frecuencia:</strong> <span class="inline-flex items-center px-4 py-1.5 rounded-full text-lg font-bold bg-purple-200 text-purple-900 dark:bg-purple-800 dark:text-purple-200 shadow-sm">{{ ucfirst($clase->frecuencia) }}</span></p>

                            @if($clase->frecuencia === 'dia')
                                <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Fecha y Hora:</strong> <span class="font-medium text-orange-600 dark:text-orange-400">{{ \Carbon\Carbon::parse($clase->fecha_hora)->format('d/m/Y H:i') }}</span></p>
                            @else
                                <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Fecha Inicio:</strong> <span class="font-medium text-orange-600 dark:text-orange-400">{{ \Carbon\Carbon::parse($clase->fecha_inicio)->format('d/m/Y') }}</span></p>
                                <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Fecha Fin:</strong> <span class="font-medium text-orange-600 dark:text-orange-400">{{ \Carbon\Carbon::parse($clase->fecha_fin)->format('d/m/Y') }}</span></p>
                                <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Días de la Semana:</strong> {{ $clase->dias_semana ? implode(', ', explode(',', $clase->dias_semana)) : 'No especificado' }}</p>
                                <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Hora Inicio:</strong> <span class="font-medium">{{ \Carbon\Carbon::parse($clase->hora_inicio)->format('H:i') }}</span></p>
                            @endif

                            <p class="mb-4"><strong class="text-gray-900 dark:text-gray-100">Duración:</strong> {{ $clase->duracion ? $clase->duracion . ' minutos' : 'No especificada' }}</p>
                        </div>
                    </div>
                </section>

                {{-- Sección de Acciones (Botones) --}}
                <div class="flex justify-center gap-6 mt-12 pt-8 border-t-2 border-gray-200 dark:border-gray-700"> {{-- Centramos los botones y damos más espacio --}}
                    <a href="{{ route('entrenador.clases-individuales.edit', ['claseIndividual' => $clase->id]) }}"
                       class="inline-flex items-center px-8 py-4 border border-transparent text-lg font-semibold rounded-lg shadow-lg text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-3 focus:ring-offset-2 focus:ring-yellow-500 transition ease-in-out duration-300 transform hover:scale-105 hover:shadow-xl">
                        <svg class="-ml-1 mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.38-2.828-2.829z" />
                        </svg>
                        Editar Clase Individual
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>